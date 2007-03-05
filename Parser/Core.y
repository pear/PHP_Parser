%name PHP_Parser_Core
%declare_class {class PHP_Parser_Core}

%syntax_error {
/* ?><?php */
    echo "Syntax Error on line " . $this->lex->line . ": token '" . 
        $this->lex->value . "' while parsing rule:";
    foreach ($this->yystack as $entry) {
        echo $this->tokenName($entry->major) . ' ';
    }
    foreach ($this->yy_get_expected_tokens($yymajor) as $token) {
        $expect[] = self::$yyTokenName[$token];
    }
    if (count($expect) > 5) {
        $expect = array_slice($expect, 0, 5);
        $expect[] = '...';
    }
    throw new Exception('Unexpected ' . $this->tokenName($yymajor) . '(' . $TOKEN
        . '), expected one of: ' . implode(',', $expect));
}
%include_class {
    static public $transTable = array();
    public $lex;
    public $functions = array();
    public $classes = array();
    public $interfaces = array();
    public $includes = array();
    public $globals = array();
    

    function __construct($lex)
    {
        $this->lex = $lex;
        if (!count(self::$transTable)) {
            $start = 240; // start nice and low to be sure
            while (token_name($start) == 'UNKNOWN') {
                $start++;
            }
            $hash = array_flip(self::$yyTokenName);
            $map =
                array(
                    ord(',') => self::COMMA,
                    ord('=') => self::EQUALS,
                    ord('?') => self::QUESTION,
                    ord(':') => self::COLON,
                    ord('|') => self::BAR,
                    ord('^') => self::CARAT,
                    ord('&') => self::AMPERSAND,
                    ord('<') => self::LESSTHAN,
                    ord('>') => self::GREATERTHAN,
                    ord('+') => self::PLUS,
                    ord('-') => self::MINUS,
                    ord('.') => self::DOT,
                    ord('*') => self::TIMES,
                    ord('/') => self::DIVIDE,
                    ord('%') => self::PERCENT,
                    ord('!') => self::EXCLAM,
                    ord('~') => self::TILDE,
                    ord('@') => self::AT,
                    ord('[') => self::LBRACKET,
                    ord('(') => self::LPAREN,
                    ord(')') => self::RPAREN,
                    ord(';') => self::SEMI,
                    ord('{') => self::LCURLY,
                    ord('}') => self::RCURLY,
                    ord('`') => self::BACKQUOTE,
                    ord('$') => self::DOLLAR,
                    ord(']') => self::RBRACKET,
                    ord('"') => self::DOUBLEQUOTE,
                    ord("'") => self::SINGLEQUOTE,
                );
            for ($i = $start; $i < self::YYERRORSYMBOL + $start; $i++) {
                $lt = token_name($i);
                $lt = ($lt == 'T_DOUBLE_COLON') ?  'T_PAAMAYIM_NEKUDOTAYIM' : $lt;
//                echo "$lt has hash? ".$hash[$lt]."\n";
                if (!isset($hash[$lt])) {
                    continue;
                }
                
                //echo "compare $lt with {$tokens[$i]}\n";
                $map[$i] = $hash[$lt];
            }
            //print_r($map);
            // set the map to false if nothing in there.
            self::$transTable = $map;
        }
    }

    public $data;
}

%left T_INCLUDE T_INCLUDE_ONCE T_EVAL T_REQUIRE T_REQUIRE_ONCE.
%left COMMA.
%left T_LOGICAL_OR.
%left T_LOGICAL_XOR.
%left T_LOGICAL_AND.
%right T_PRINT.
%left EQUALS T_PLUS_EQUAL T_MINUS_EQUAL T_MUL_EQUAL T_DIV_EQUAL T_CONCAT_EQUAL T_MOD_EQUAL T_AND_EQUAL T_OR_EQUAL T_XOR_EQUAL T_SL_EQUAL T_SR_EQUAL.
%left QUESTION COLON.
%left T_BOOLEAN_OR.
%left T_BOOLEAN_AND.
%left BAR.
%left CARAT.
%left AMPERSAND.
%nonassoc T_IS_EQUAL T_IS_NOT_EQUAL T_IS_IDENTICAL T_IS_NOT_IDENTICAL.
%nonassoc LESSTHAN T_IS_SMALLER_OR_EQUAL GREATERTHAN T_IS_GREATER_OR_EQUAL.
%left T_SL T_SR.
%left PLUS MINUS DOT.
%left TIMES DIVIDE PERCENT.
%right EXCLAM.
%nonassoc T_INSTANCEOF.
%right TILDE T_INC T_DEC T_INT_CAST T_DOUBLE_CAST T_STRING_CAST T_UNICODE_CAST T_BINARY_CAST T_ARRAY_CAST T_OBJECT_CAST T_BOOL_CAST T_UNSET_CAST AT.
%right LBRACKET.
%nonassoc T_NEW T_CLONE.
%left T_ELSEIF.
%left T_ELSE.
%left T_ENDIF.
%right T_STATIC T_ABSTRACT T_FINAL T_PRIVATE T_PROTECTED T_PUBLIC.

%parse_accept {
}

start ::= top_statement_list(B). {$this->data = B->metadata;}

top_statement_list(A) ::= top_statement_list(B) top_statement(C). {
    A = B;
    A[] = C;
}
top_statement_list(A) ::= . {A = new PHP_Parser_CoreyyToken('');}

top_statement(A) ::= statement(B). {A = B;}
top_statement(A) ::= function_declaration_statement(B). {A = B;}
top_statement(A) ::= class_declaration_statement(B). {A = B;}
top_statement ::= T_HALT_COMPILER LPAREN RPAREN SEMI. { $this->lex->haltParsing(); }

statement(A) ::= unticked_statement(B). {A = B;}

unticked_statement(A) ::= LCURLY inner_statement_list(B) RCURLY. {A = B;}
unticked_statement(A) ::= T_IF LPAREN expr(E) RPAREN statement(I) elseif_list(EL) else_single(ELL). {
    A = new PHP_Parser_CoreyyToken('');
    A[] = E;
    A[] = I;
    A[] = EL;
    A[] = ELL;
}
unticked_statement(A) ::= T_IF LPAREN expr(E) RPAREN COLON inner_statement_list(I) new_elseif_list(EL) new_else_single(ELL) T_ENDIF SEMI. {
    A = new PHP_Parser_CoreyyToken('if (' . E->string . '):' . I->string . EL->string . ELL->string . 'endif;');
    A[] = E;
    A[] = I;
    A[] = EL;
    A[] = ELL;
}
unticked_statement(A) ::= T_WHILE LPAREN expr(B) RPAREN while_statement(C). {
    A = new PHP_Parser_CoreyyToken('');
    A[] = B;
    A[] = C;
}
unticked_statement(A) ::= T_DO statement(B) T_WHILE LPAREN expr(C) RPAREN SEMI. {
    A = new PHP_Parser_CoreyyToken('');
    A[] = B;
    A[] = C;
}
unticked_statement(A) ::= T_FOR 
            LPAREN
                for_expr(B)
            SEMI 
                for_expr(C)
            SEMI
                for_expr(D)
            RPAREN
            for_statement(E). {
    A = new PHP_Parser_CoreyyToken('');
    A[] = B;
    A[] = C;
    A[] = D;
    A[] = E;
}
unticked_statement(A) ::= T_SWITCH LPAREN expr(B) RPAREN switch_case_list(C). {
    A = new PHP_Parser_CoreyyToken('');
    A[] = B;
    A[] = C;
}
unticked_statement ::= T_BREAK SEMI.
unticked_statement(A) ::= T_BREAK expr(B) SEMI. {
    A = new PHP_Parser_CoreyyToken('');
    A[] = B;
}
unticked_statement ::= T_CONTINUE SEMI.
unticked_statement(A) ::= T_CONTINUE expr(B) SEMI. {
    A = new PHP_Parser_CoreyyToken('', B);
}
unticked_statement ::= T_RETURN SEMI.
unticked_statement(A) ::= T_RETURN expr_without_variable(B) SEMI. {
    A = new PHP_Parser_CoreyyToken('return ' . B->string . ';', B);
}
unticked_statement(A) ::= T_RETURN variable(B) SEMI. {
    A = new PHP_Parser_CoreyyToken('return ' . B->string . ';', B);
}
unticked_statement(A) ::= T_GLOBAL global_var_list(B) SEMI. {A = B;}
unticked_statement(A) ::= T_STATIC static_var_list(B) SEMI. {A = B;}
unticked_statement(A) ::= T_ECHO echo_expr_list(B) SEMI. {
    A = new PHP_Parser_CoreyyToken('', B);
}
unticked_statement ::= T_INLINE_HTML.
unticked_statement(A) ::= expr(B) SEMI. {A = B;}
unticked_statement(A) ::= T_USE use_filename(B) SEMI. {
    A = new PHP_Parser_CoreyyToken('', array('uses' => trim(B)));
    // not that "uses" would actually work in real life
}
unticked_statement(A) ::= T_UNSET LPAREN unset_variables(B) RPAREN SEMI. {
    A = new PHP_Parser_CoreyyToken('', B);
}
unticked_statement(A) ::= T_FOREACH LPAREN variable(B) T_AS 
        foreach_variable foreach_optional_arg RPAREN
        foreach_statement(C). {
    A = new PHP_Parser_CoreyyToken('', B);
    A[] = C;
}
unticked_statement(A) ::= T_FOREACH LPAREN expr_without_variable(B) T_AS 
        variable foreach_optional_arg RPAREN
        foreach_statement(C). {
    A = new PHP_Parser_CoreyyToken('', B);
    A[] = C;
}
unticked_statement(A) ::= T_DECLARE LPAREN declare_list(B) RPAREN declare_statement(C). {
    A = new PHP_Parser_CoreyyToken('', B);
    A[] = C;
}
unticked_statement ::= SEMI.
unticked_statement(A) ::= T_TRY LCURLY inner_statement_list(B) RCURLY
        T_CATCH LPAREN
        fully_qualified_class_name(C)
        T_VARIABLE RPAREN
        LCURLY inner_statement_list(D) RCURLY
        additional_catches(E). {
    A = new PHP_Parser_CoreyyToken('');
    A[] = array('catches' => C);
    A[] = B;
    A[] = D;
    A[] = E;
}
unticked_statement(A) ::= T_THROW expr(B) SEMI. {
    if (B->metadata && isset(B->metadata[0]) && isset(B->metadata[0]['uses']) &&
          B->metadata[0]['uses'] === 'class') {
        A = new PHP_Parser_CoreyyToken('throw ' . B->string, array('throws' => B->metadata[0]['name']));
    } else {
        A = new PHP_Parser_CoreyyToken('throw ' . B->string);
        A[] = B;
    }
}

additional_catches(A) ::= non_empty_additional_catches(B). {A = B;}
additional_catches ::= .

non_empty_additional_catches(A) ::= additional_catch(B). {A = B;}
non_empty_additional_catches(A) ::= non_empty_additional_catches(B) additional_catch(C). {
    A = B;
    A[] = C;
}

additional_catch(A) ::= T_CATCH LPAREN fully_qualified_class_name(B) T_VARIABLE RPAREN LCURLY inner_statement_list(C) RCURLY. {
    A = new PHP_Parser_CoreyyToken('', C);
    A[] = array('catches' => B);
}

inner_statement_list(A) ::= inner_statement_list(B) inner_statement(C). {
    A = B;
    A[] = C;
}
inner_statement_list(A) ::= . {A = new PHP_Parser_CoreyyToken('');}

inner_statement(A) ::= statement(B). {
    A = B;
}
inner_statement(A) ::= function_declaration_statement(B). {
    A = B;
}
inner_statement(A) ::= class_declaration_statement(B). {
    A = B;
}
inner_statement ::= T_HALT_COMPILER LPAREN RPAREN SEMI. {
    throw new Exception("Error on line " . $this->lex->line .
        ": __halt_compiler(); can only be used at the top level");
}

function_declaration_statement(A) ::= unticked_function_declaration_statement(B). {
    A = B;
}

class_declaration_statement(A) ::= unticked_class_declaration_statement(B). {
    A = B;
}

get_func_line(A) ::= T_FUNCTION. {A = $this->lex->line;}
unticked_function_declaration_statement(A) ::=
        get_func_line(LINE) is_reference(ref) T_STRING(funcname) LPAREN parameter_list(params) RPAREN
        LCURLY inner_statement_list(funcinfo) RCURLY. {
    A = new PHP_Parser_CoreyyToken('function ' . (ref ? '&' : '') .
       funcname . '(' . params->string . ')');
    list($doc, $parsed, $line) = $this->lex->getLastComment();
    A[] = array(
        'type' => 'function',
        'startline' => LINE,
        'endline' => $this->lex->line,
        'returnsref' => ref,
        'name' => funcname,
        'parameters' => params->metadata,
        'info' => funcinfo->metadata,
        'doc' => $doc,
        'parseddoc' => $parsed,
        'docline' => $line,
    );
    $this->functions[funcname][] = array(
        'type' => 'function',
        'startline' => LINE,
        'endline' => $this->lex->line,
        'returnsref' => ref,
        'name' => funcname,
        'parameters' => params->metadata,
        'info' => funcinfo->metadata,
        'doc' => $doc,
        'parseddoc' => $parsed,
        'docline' => $line,
    );
}

unticked_class_declaration_statement(A) ::=
        class_entry_type(classtype) T_STRING(C) extends_from(ext)
            implements_list(impl)
            LCURLY
                class_statement_list(cinfo)
            RCURLY. {
    list($doc, $parsed, $line) = $this->lex->getLastComment();
    A = new PHP_Parser_CoreyyToken('', array(
       'type' => classtype['type'],
       'startline' => classtype['line'],
       'endline' => $this->lex->line,
       'modifiers' => classtype['modifiers'],
       'name' => C,
       'extends' => ext->metadata,
       'implements' => impl->metadata,
       'info' => cinfo->metadata,
       'doc' => $doc,
       'parseddoc' => $parsed,
       'docline' => $line,
    ));
    $this->classes[C][] = array(
       'type' => classtype['type'],
       'startline' => classtype['line'],
       'endline' => $this->lex->line,
       'modifiers' => classtype['modifiers'],
       'name' => C,
       'extends' => ext->metadata,
       'implements' => impl->metadata,
       'info' => cinfo->metadata,
       'doc' => $doc,
       'parseddoc' => $parsed,
       'docline' => $line,
    );
}
unticked_class_declaration_statement(A) ::=
        interface_entry(LINE) T_STRING(B)
            interface_extends_list(C)
            LCURLY
                class_statement_list(D)
            RCURLY. {
    list($doc, $parsed, $line) = $this->lex->getLastComment();
    A = new PHP_Parser_CoreyyToken('', array(
       'type' => 'interface',
       'startline' => LINE,
       'endline' => $this->lex->line,
       'name' => B,
       'extends' => C->metadata,
       'info' => D->metadata,
       'doc' => $doc,
       'parseddoc' => $parsed,
       'docline' => $line,
    ));
    $this->interfaces[B][] = array(
       'type' => 'interface',
       'startline' => LINE,
       'endline' => $this->lex->line,
       'name' => B,
       'extends' => C->metadata,
       'info' => D->metadata,
       'doc' => $doc,
       'parseddoc' => $parsed,
       'docline' => $line,
    );
}

class_entry_type(A) ::= T_CLASS. { A = new PHP_Parser_CoreyyToken('', array('type' => 'class', 'modifiers' => array(), 'line' => $this->lex->line)); }
class_entry_type(A) ::= T_ABSTRACT T_CLASS. {
    A = new PHP_Parser_CoreyyToken('', array('type' => 'class', 'modifiers' => array('abstract'), 'line' => $this->lex->line));
}
class_entry_type(A) ::= T_FINAL T_CLASS. {
    A = new PHP_Parser_CoreyyToken('', array('type' => 'class', 'modifiers' => array('final'), 'line' => $this->lex->line));
}

extends_from(A) ::= T_EXTENDS fully_qualified_class_name(B). {A = new PHP_Parser_CoreyyToken(B, array(B));}
extends_from(A) ::= . {A = new PHP_Parser_CoreyyToken('');}

interface_entry(A) ::= T_INTERFACE. {A = $this->lex->line;}

interface_extends_list(A) ::= T_EXTENDS interface_list(B). {A = B;}
interface_extends_list(A) ::= . {A = new PHP_Parser_CoreyyToken('');}

implements_list(A) ::= . {A = new PHP_Parser_CoreyyToken('');}
implements_list(A) ::= T_IMPLEMENTS interface_list(B). {A = B;}

interface_list(A) ::= fully_qualified_class_name(B). {A = new PHP_Parser_CoreyyToken('', array(B));}
interface_list(A) ::= interface_list(list) COMMA fully_qualified_class_name(B). {
    A = list;
    A[] = array(B);
}

expr(A) ::= r_variable(B). {A = B;}
expr(A) ::= expr_without_variable(B). {A = B;}

expr_without_variable(A) ::= T_LIST LPAREN assignment_list(B) RPAREN EQUALS expr(C). {
    A = new PHP_Parser_CoreyyToken('list(' . B->string . ') = ' . C->string, B);
    A[] = C;
}
expr_without_variable(A) ::= variable(VAR) EQUALS expr(E). {
    if ($this->lex->globalSearch(VAR->string)) {
        list($doc, $parsed, $line) = $this->lex->getLastComment();
        A = new PHP_Parser_CoreyyToken(VAR->string . ' = ' . E->string,
            array(
                'type' => 'global',
                'name' => VAR->string,
                'line' => $this->lex->line,
                'default' => E->string,
                'doc' => $doc,
                'parseddoc' => $parsed,
                'docline' => $line,
            ));
        A[] = VAR;
        A[] = E;
        $this->globals[VAR->string][] = array(
                'type' => 'global',
                'name' => VAR->string,
                'line' => $this->lex->line,
                'default' => E->string,
                'doc' => $doc,
                'parseddoc' => $parsed,
                'docline' => $line,
            );
    } else {
        A = new PHP_Parser_CoreyyToken(VAR->string . ' = ' . E->string, VAR);
        A[] = E;
    }
}
expr_without_variable(A) ::= variable(VAR) EQUALS AMPERSAND variable(E).{
    if ($this->lex->globalSearch(VAR->string)) {
        list($doc, $parsed, $line) = $this->lex->getLastComment();
        A = new PHP_Parser_CoreyyToken(VAR->string . ' = ' . E->string,
            array(
                'type' => 'global',
                'name' => VAR->string,
                'line' => $this->lex->line,
                'default' => '&' . E->string,
                'doc' => $doc,
                'parseddoc' => $parsed,
                'docline' => $line,
            ));
        A[] = VAR;
        A[] = E;
        $this->globals[VAR->string][] = 
            array(
                'type' => 'global',
                'name' => VAR->string,
                'line' => $this->lex->line,
                'default' => '&' . E->string,
                'doc' => $doc,
                'parseddoc' => $parsed,
                'docline' => $line,
            );
    } else {
        A = new PHP_Parser_CoreyyToken(VAR->string . ' = &' . E->string, VAR);
        A[] = E;
    }
}

expr_without_variable(A) ::= variable(VAR) EQUALS AMPERSAND T_NEW class_name_reference(CL) ctor_arguments(ARGS). {
    $c = is_string(CL) ? CL : CL->string;
    if ($this->lex->globalSearch(VAR->string)) {
        list($doc, $parsed, $line) = $this->lex->getLastComment();
        A = new PHP_Parser_CoreyyToken(VAR->string . ' = &new ' . $c . ARGS->string,
            array(
                'type' => 'global',
                'name' => VAR->string,
                'line' => $this->lex->line,
                'default' => '&new ' . CL->string . ARGS->string,
                'doc' => $doc,
                'parseddoc' => $parsed,
                'docline' => $line,
            ));
        A[] = VAR;
        $this->globals[VAR->string][] =
            array(
                'type' => 'global',
                'name' => VAR->string,
                'line' => $this->lex->line,
                'default' => '&new ' . CL->string . ARGS->string,
                'doc' => $doc,
                'parseddoc' => $parsed,
                'docline' => $line,
            );
    } else {
        A = new PHP_Parser_CoreyyToken(VAR->string . ' = &new ' . $c . ARGS->string, VAR);
    }
    if (is_string(CL)) {
        A[] = array('uses' => 'class', 'name' => trim(CL));
    }
    A[] = ARGS;
}
expr_without_variable(A) ::= T_NEW class_name_reference(B) ctor_arguments(C). {
    $b = is_string(B) ? B : B->string;
    A = new PHP_Parser_CoreyyToken('new ' . $b . C->string, B);
    A[] = C;
    if (is_string(B)) {
        A[] = array('uses' => 'class', 'name' => trim(B));
    }
}
expr_without_variable(A) ::= T_CLONE expr(B). {
    A = new PHP_Parser_CoreyyToken('clone ' . B->string, B);
}
expr_without_variable(A) ::= variable(B) T_PLUS_EQUAL expr(C). {
    A = new PHP_Parser_CoreyyToken(B->string . ' += ' . C->string, B);
    A[] = C;
}
expr_without_variable(A) ::= variable(B) T_MINUS_EQUAL expr(C). {
    A = new PHP_Parser_CoreyyToken(B->string . ' -= ' . C->string, B);
    A[] = C;
}

expr_without_variable(A) ::= variable(B) T_MUL_EQUAL expr(C). {
    A = new PHP_Parser_CoreyyToken(B->string . ' *= ' . C->string, B);
    A[] = C;
}

expr_without_variable(A) ::= variable(B) T_DIV_EQUAL expr(C). {
    A = new PHP_Parser_CoreyyToken(B->string . ' /= ' . C->string, B);
    A[] = C;
}

expr_without_variable(A) ::= variable(B) T_CONCAT_EQUAL expr(C). {
    A = new PHP_Parser_CoreyyToken(B->string . ' .= ' . C->string, B);
    A[] = C;
}

expr_without_variable(A) ::= variable(B) T_MOD_EQUAL expr(C). {
    A = new PHP_Parser_CoreyyToken(B->string . ' %= ' . C->string, B);
    A[] = C;
}

expr_without_variable(A) ::= variable(B) T_AND_EQUAL expr(C). {
    A = new PHP_Parser_CoreyyToken(B->string . ' &= ' . C->string, B);
    A[] = C;
}

expr_without_variable(A) ::= variable(B) T_OR_EQUAL expr(C). {
    A = new PHP_Parser_CoreyyToken(B->string . ' |= ' . C->string, B);
    A[] = C;
}

expr_without_variable(A) ::= variable(B) T_XOR_EQUAL expr(C). {
    A = new PHP_Parser_CoreyyToken(B->string . ' ^= ' . C->string, B);
    A[] = C;
}

expr_without_variable(A) ::= variable(B) T_SL_EQUAL expr(C). {
    A = new PHP_Parser_CoreyyToken(B->string . ' <<= ' . C->string, B);
    A[] = C;
}

expr_without_variable(A) ::= variable(B) T_SR_EQUAL expr(C). {
    A = new PHP_Parser_CoreyyToken(B->string . ' >>= ' . C->string, B);
    A[] = C;
}

expr_without_variable(A) ::= rw_variable(B) T_INC. {
    A = new PHP_Parser_CoreyyToken(B->string . '++', B);
}
expr_without_variable(A) ::= T_INC rw_variable(B). {
    A = new PHP_Parser_CoreyyToken('++' . B->string, B);
}
expr_without_variable(A) ::= rw_variable(B) T_DEC. {
    A = new PHP_Parser_CoreyyToken(B->string . '--', B);
}
expr_without_variable(A) ::= T_DEC rw_variable(B). {
    A = new PHP_Parser_CoreyyToken('--' . B->string, B);
}
expr_without_variable(A) ::= expr(B) T_BOOLEAN_OR expr(C). {
    A = new PHP_Parser_CoreyyToken(B->string . ' || ' . C->string, B);
    A[] = C;
}
expr_without_variable(A) ::= expr(B) T_BOOLEAN_AND expr(C). {
    A = new PHP_Parser_CoreyyToken(B->string . ' && ' . C->string, B);
    A[] = C;
}
expr_without_variable(A) ::= expr(B) T_LOGICAL_OR expr(C). {
    A = new PHP_Parser_CoreyyToken(B->string . ' OR ' . C->string, B);
    A[] = C;
}
expr_without_variable(A) ::= expr(B) T_LOGICAL_AND expr(C). {
    A = new PHP_Parser_CoreyyToken(B->string . ' AND ' . C->string, B);
    A[] = C;
}
expr_without_variable(A) ::= expr(B) T_LOGICAL_XOR expr(C). {
    A = new PHP_Parser_CoreyyToken(B->string . ' XOR ' . C->string, B);
    A[] = C;
}
expr_without_variable(A) ::= expr(B) BAR expr(C). {
    A = new PHP_Parser_CoreyyToken(B->string . ' | ' . C->string, B);
    A[] = C;
}
expr_without_variable(A) ::= expr(B) AMPERSAND expr(C). {
    A = new PHP_Parser_CoreyyToken(B->string . ' & ' . C->string, B);
    A[] = C;
}
expr_without_variable(A) ::= expr(B) CARAT expr(C). {
    A = new PHP_Parser_CoreyyToken(B->string . ' ^ ' . C->string, B);
    A[] = C;
}
expr_without_variable(A) ::= expr(B) DOT expr(C). {
    A = new PHP_Parser_CoreyyToken(B->string . ' . ' . C->string, B);
    A[] = C;
}
expr_without_variable(A) ::= expr(B) PLUS expr(C). {
    A = new PHP_Parser_CoreyyToken(B->string . ' + ' . C->string, B);
    A[] = C;
}
expr_without_variable(A) ::= expr(B) MINUS expr(C). {
    A = new PHP_Parser_CoreyyToken(B->string . ' - ' . C->string, B);
    A[] = C;
}
expr_without_variable(A) ::= expr(B) TIMES expr(C). {
    A = new PHP_Parser_CoreyyToken(B->string . ' * ' . C->string, B);
    A[] = C;
}
expr_without_variable(A) ::= expr(B) DIVIDE expr(C). {
    A = new PHP_Parser_CoreyyToken(B->string . ' / ' . C->string, B);
    A[] = C;
}
expr_without_variable(A) ::= expr(B) PERCENT expr(C). {
    A = new PHP_Parser_CoreyyToken(B->string . ' % ' . C->string, B);
    A[] = C;
}
expr_without_variable(A) ::= expr(B) T_SL expr(C). {
    A = new PHP_Parser_CoreyyToken(B->string . ' << ' . C->string, B);
    A[] = C;
}
expr_without_variable(A) ::= expr(B) T_SR expr(C). {
    A = new PHP_Parser_CoreyyToken(B->string . ' >> ' . C->string, B);
    A[] = C;
}
expr_without_variable(A) ::= PLUS expr(B). {
    A = new PHP_Parser_CoreyyToken('+' . B->string, B);
}
expr_without_variable(A) ::= MINUS expr(B). {
    A = new PHP_Parser_CoreyyToken('-' . B->string, B);
}
expr_without_variable(A) ::= EXCLAM expr(B). {
    A = new PHP_Parser_CoreyyToken('!' . B->string, B);
}
expr_without_variable(A) ::= TILDE expr(B). {
    A = new PHP_Parser_CoreyyToken('~' . B->string, B);
}
expr_without_variable(A) ::= expr(B) T_IS_IDENTICAL expr(C). {
    A = new PHP_Parser_CoreyyToken(B->string . ' === ' . C->string, B);
    A[] = C;
}
expr_without_variable(A) ::= expr(B) T_IS_NOT_IDENTICAL expr(C). {
    A = new PHP_Parser_CoreyyToken(B->string . ' !== ' . C->string, B);
    A[] = C;
}
expr_without_variable(A) ::= expr(B) T_IS_EQUAL expr(C). {
    A = new PHP_Parser_CoreyyToken(B->string . ' == ' . C->string, B);
    A[] = C;
}
expr_without_variable(A) ::= expr(B) T_IS_NOT_EQUAL expr(C). {
    A = new PHP_Parser_CoreyyToken(B->string . ' != ' . C->string, B);
    A[] = C;
}
expr_without_variable(A) ::= expr(B) LESSTHAN expr(C). {
    A = new PHP_Parser_CoreyyToken(B->string . ' < ' . C->string, B);
    A[] = C;
}
expr_without_variable(A) ::= expr(B) T_IS_SMALLER_OR_EQUAL expr(C). {
    A = new PHP_Parser_CoreyyToken(B->string . ' <= ' . C->string, B);
    A[] = C;
}
expr_without_variable(A) ::= expr(B) GREATERTHAN expr(C). {
    A = new PHP_Parser_CoreyyToken(B->string . ' > ' . C->string, B);
    A[] = C;
}
expr_without_variable(A) ::= expr(B) T_IS_GREATER_OR_EQUAL expr(C). {
    A = new PHP_Parser_CoreyyToken(B->string . ' >= ' . C->string, B);
    A[] = C;
}
expr_without_variable(A) ::= expr(B) T_INSTANCEOF class_name_reference(CL). {
    $c = is_string(CL) ? CL : CL->string;
    A = new PHP_Parser_CoreyyToken(B->string . ' instanceof ' . $c, B);
    if (!is_string(CL)) {
        A[] = CL;
    }
}
expr_without_variable(A) ::= LPAREN expr(B) RPAREN. {
    A = new PHP_Parser_CoreyyToken('(' . B->string . ')', B);
}
expr_without_variable(A) ::= expr(B) QUESTION
        expr(C) COLON
        expr(D). {
    A = new PHP_Parser_CoreyyToken(B->string . ' ? ' . C->string . ' : ' . D->string, B);
    A[] = C;
    A[] = D;
}
expr_without_variable(A) ::= internal_functions_in_yacc(B). {A = B;}
expr_without_variable(A) ::= T_INT_CAST expr(B). {
    A = new PHP_Parser_CoreyyToken('(int) ' . B->string, B);
}
expr_without_variable(A) ::= T_DOUBLE_CAST expr(B). {
    A = new PHP_Parser_CoreyyToken('(double) ' . B->string, B);
}
expr_without_variable(A) ::= T_STRING_CAST expr(B). {
    A = new PHP_Parser_CoreyyToken('(string) ' . B->string, B);
}
expr_without_variable(A) ::= T_ARRAY_CAST expr(B). {
    A = new PHP_Parser_CoreyyToken('(array) ' . B->string, B);
}
expr_without_variable(A) ::= T_OBJECT_CAST expr(B). {
    A = new PHP_Parser_CoreyyToken('(object) ' . B->string, B);
}
expr_without_variable(A) ::= T_BINARY_CAST expr(B). {
    A = new PHP_Parser_CoreyyToken('(binary) ' . B->string, B);
}
expr_without_variable(A) ::= T_BOOL_CAST expr(B). {
    A = new PHP_Parser_CoreyyToken('(bool) ' . B->string, B);
}
expr_without_variable(A) ::= T_UNSET_CAST expr(B). {
    A = new PHP_Parser_CoreyyToken('(unset) ' . B->string, B);
}
expr_without_variable(A) ::= T_EXIT exit_expr(B). {
    A = new PHP_Parser_CoreyyToken('exit ' . B->string, B);
}
expr_without_variable(A) ::= AT expr(B). {
    A = new PHP_Parser_CoreyyToken('@' . B->string, B);
}
expr_without_variable(A) ::= scalar(B). {
    A = new PHP_Parser_CoreyyToken(B->string, B);
}
expr_without_variable(A) ::= expr_without_variable_t_array LPAREN array_pair_list(B) RPAREN. {
    $this->lex->stopTrackingWhitespace();
    A = new PHP_Parser_CoreyyToken('array(' . B->string . ')', B);
}
expr_without_variable(A) ::= BACKQUOTE encaps_list(B) BACKQUOTE. {
    A = new PHP_Parser_CoreyyToken('`' . B->string . '`');
}
expr_without_variable(A) ::= T_PRINT expr(B). {
    A = new PHP_Parser_CoreyyToken('print ' . B->string, B);
}

expr_without_variable_t_array ::= T_ARRAY. {$this->lex->trackWhitespace();}

exit_expr(A) ::= LPAREN RPAREN. {A = new PHP_Parser_CoreyyToken('()');}
exit_expr(A) ::= LPAREN expr(B) RPAREN. {A = new PHP_Parser_CoreyyToken('(' . B->string . ')', B);}
exit_expr(A) ::= . {A = new PHP_Parser_CoreyyToken('');}

common_scalar(A) ::=
        T_LNUMBER
       |T_DNUMBER
       |T_CONSTANT_ENCAPSED_STRING
       |T_LINE
       |T_FILE
       |T_CLASS_C
       |T_METHOD_C
       |T_FUNC_C(B). {A = B;}

/* compile-time evaluated scalars */
static_scalar(A) ::= common_scalar(B). {A = B;}
static_scalar(A) ::= T_STRING(B). {A = B;}
static_scalar(A) ::= PLUS static_scalar(B). {A = B;}
static_scalar(A) ::= MINUS static_scalar(B). {A = '-' . B;}
static_scalar(A) ::= static_scalar_t_array(B) LPAREN(C) static_array_pair_list(D) RPAREN(E). {
    A = B . C . D . E;
    // have to do all because of nested arrays
    $this->lex->stopTrackingWhitespace(); // we only need whitespace for
                                          // array default values
}
static_scalar(A) ::= static_class_constant(B). {A = B;}

static_scalar_t_array(A) ::= T_ARRAY(B). {
    $this->lex->trackWhitespace();
    A = B;
}

static_array_pair_list(A) ::= non_empty_static_array_pair_list(B). {A = B;}
static_array_pair_list(A) ::= non_empty_static_array_pair_list(B) COMMA(C). {
    A = B . C;
}
static_array_pair_list(A) ::= . {A = '';}

non_empty_static_array_pair_list(A) ::= non_empty_static_array_pair_list(B) COMMA(C) static_scalar(D) T_DOUBLE_ARROW(E) static_scalar(F). {
    A = B . C . D . E . F;
}
non_empty_static_array_pair_list(A) ::= non_empty_static_array_pair_list(B) COMMA(C) static_scalar(D). {
    A = B . C . D;
}
non_empty_static_array_pair_list(A) ::= static_scalar(B) T_DOUBLE_ARROW(C) static_scalar(D). {
    A = B . C . D;
}
non_empty_static_array_pair_list(A) ::= static_scalar(B). {A = B;}

static_class_constant(A) ::= T_STRING(B) T_PAAMAYIM_NEKUDOTAYIM T_STRING(C). {
    A = B . '::' . C;
}

foreach_optional_arg(A) ::= T_DOUBLE_ARROW foreach_variable(B). {
    A = new PHP_Parser_CoreyyToken(' => ' . B->string, B);
}
foreach_optional_arg ::= .

foreach_variable(A) ::= w_variable(B). {A = B;}
foreach_variable(A) ::= AMPERSAND w_variable(B). {
    A = new PHP_Parser_CoreyyToken('&' . B->string, B);
}

for_statement(A) ::= statement(B). {A = B;}
for_statement(A) ::= COLON inner_statement_list(B) T_ENDFOR SEMI. {A = B;}

foreach_statement(A) ::= statement(B). {A = B;}
foreach_statement(A) ::= COLON inner_statement_list(B) T_ENDFOREACH SEMI. {A = B;}


declare_statement(A) ::= statement(B). {A = B;}
declare_statement(A) ::= COLON inner_statement_list(B) T_ENDDECLARE SEMI. {A = B;}

declare_list(A) ::= T_STRING(B) EQUALS static_scalar(C). {
    A = new PHP_Parser_CoreyyToken(B . ' = ' . C, array('declare' => B, 'default' => C));
}
declare_list(A) ::= declare_list(DEC) COMMA T_STRING(B) EQUALS static_scalar(C). {
    A = new PHP_Parser_CoreyyToken(DEC->string . ', ' . B . ' = ' . C);
    A[] = DEC;
    A[] = array('declare' => B, 'default' => C);
}

switch_case_list(A) ::= LCURLY case_list(B) RCURLY. {A = B;}
switch_case_list(A) ::= LCURLY SEMI case_list(B) RCURLY. {A = B;}
switch_case_list(A) ::= COLON case_list(B) T_ENDSWITCH SEMI. {A = B;}
switch_case_list(A) ::= COLON SEMI case_list(B) T_ENDSWITCH SEMI. {A = B;}

case_list(A) ::= case_list(LIST) T_CASE expr(B) case_separator inner_statement_list(C). {
    A = LIST;
    A[] = B;
    A[] = C;
}
case_list(A) ::= case_list(LIST) T_DEFAULT case_separator inner_statement_list(B). {
    A = LIST;
    A[] = B;
}
case_list(A) ::= . {A = new PHP_Parser_CoreyyToken('');}

case_separator ::= COLON|SEMI.

while_statement(A) ::= statement(B). {A = B;}
while_statement(A) ::= COLON inner_statement_list(B) T_ENDWHILE SEMI. {A = B;}

elseif_list(A) ::= elseif_list(B) T_ELSEIF LPAREN expr(C) RPAREN statement(D). {
    A = B;
    A[] = C;
    A[] = D;
}
elseif_list(A) ::= . {A = new PHP_Parser_CoreyyToken('');}

new_elseif_list(A) ::= new_elseif_list(B) T_ELSEIF LPAREN expr(C) RPAREN COLON inner_statement_list(D) . {
    A = B;
    A[] = C;
    A[] = D;
}
new_elseif_list(A) ::= . {A = new PHP_Parser_CoreyyToken('');}

else_single(A) ::= T_ELSE statement(B). {A = B;}
else_single(A) ::= . {A = new PHP_Parser_CoreyyToken('');}

new_else_single(A) ::= T_ELSE COLON inner_statement_list(B). {A = B;}
new_else_single(A) ::= . {A = new PHP_Parser_CoreyyToken('');}

parameter_list(A) ::= non_empty_parameter_list(B). {A = B;}
parameter_list(A) ::= . {A = new PHP_Parser_CoreyyToken('');}

non_empty_parameter_list(A) ::= optional_class_type(T) T_VARIABLE(V). {
    A = new PHP_Parser_CoreyyToken(T . V, array(
            array(
                'typehint' => T,
                'param' => V,
                'isreference' => false,
                'default' => null,
            )
        ));
}
non_empty_parameter_list(A) ::= optional_class_type(T) AMPERSAND T_VARIABLE(V). {
    A = new PHP_Parser_CoreyyToken(T . '&' . V, array(
            array(
                'typehint' => T,
                'param' => V,
                'isreference' => true,
                'default' => null,
            )
        ));
}
non_empty_parameter_list(A) ::= optional_class_type(T) AMPERSAND T_VARIABLE(V) EQUALS static_scalar(D). {
    A = new PHP_Parser_CoreyyToken(T . '&' . V . ' = ' . D, array(
            array(
                'typehint' => T,
                'param' => V,
                'isreference' => true,
                'default' => D,
            )
        ));
}
non_empty_parameter_list(A) ::= optional_class_type(T) T_VARIABLE(V) EQUALS static_scalar(D). {
    A = new PHP_Parser_CoreyyToken(T . V . ' = ' . D, array(
            array(
                'typehint' => T,
                'param' => V,
                'isreference' => false,
                'default' => D,
            )
        ));
}
non_empty_parameter_list(A) ::= non_empty_parameter_list(list) COMMA optional_class_type(T) T_VARIABLE(V). {
    A = new PHP_Parser_CoreyyToken(list->string . ', ' . T . V, list);
    A[] = 
        array(
            'typehint' => T,
            'param' => V,
            'isreference' => false,
            'default' => null,
        );
}
non_empty_parameter_list(A) ::= non_empty_parameter_list(list) COMMA optional_class_type(T) AMPERSAND T_VARIABLE(V). {
    A = new PHP_Parser_CoreyyToken(list->string . ', ' . T . '&' . V, list);
    A[] = 
        array(
            'typehint' => T,
            'param' => V,
            'isreference' => true,
            'default' => null,
        );
}
non_empty_parameter_list(A) ::= non_empty_parameter_list(list) COMMA optional_class_type(T) AMPERSAND T_VARIABLE(V) EQUALS static_scalar(D). {
    A = new PHP_Parser_CoreyyToken(list->string . ', ' . T . V . ' = ' . D, list);
    A[] = 
        array(
            'typehint' => T,
            'param' => V,
            'isreference' => true,
            'default' => D,
        );
}
non_empty_parameter_list(A) ::= non_empty_parameter_list(list) COMMA optional_class_type(T) T_VARIABLE(V) EQUALS static_scalar(D). {
    A = new PHP_Parser_CoreyyToken(list->string . ', ' . T . V . ' = ' . D, list);
    A[] = 
        array(
            'typehint' => T,
            'param' => V,
            'isreference' => false,
            'default' => D,
        );
}


optional_class_type(A) ::= T_STRING|T_ARRAY(B). {A = B;}
optional_class_type(A) ::= . {A = '';}

function_call_parameter_list(A) ::= non_empty_function_call_parameter_list(B). {A = B;}
function_call_parameter_list(A) ::= . {A = new PHP_Parser_CoreyyToken('');}

non_empty_function_call_parameter_list(A) ::= expr_without_variable(B). {A = new PHP_Parser_CoreyyToken(B);}
non_empty_function_call_parameter_list(A) ::= variable(B). {A = new PHP_Parser_CoreyyToken(B);}
non_empty_function_call_parameter_list(A) ::= AMPERSAND w_variable(B). {
    if (B instanceof PHP_Parser_CoreyyToken) {
        $b = B->string;
    } else {
        $b = (string) B;
    }
    A = new PHP_Parser_CoreyyToken('&' . $b, B);}
non_empty_function_call_parameter_list(A) ::= non_empty_function_call_parameter_list(LIST) COMMA expr_without_variable(B). {
    if (B instanceof PHP_Parser_CoreyyToken) {
        $b = B->string;
    } else {
        $b = (string) B;
    }
    A = new PHP_Parser_CoreyyToken(LIST->string . ', ' . $b, LIST);
    A[] = B;
}
non_empty_function_call_parameter_list(A) ::= non_empty_function_call_parameter_list(LIST) COMMA variable(B). {
    if (B instanceof PHP_Parser_CoreyyToken) {
        $b = B->string;
    } else {
        $b = (string) B;
    }
    A = new PHP_Parser_CoreyyToken(LIST->string . ', ' . $b, LIST);
    A[] = B;
}
non_empty_function_call_parameter_list(A) ::= non_empty_function_call_parameter_list(LIST) COMMA AMPERSAND w_variable(B). {
    if (B instanceof PHP_Parser_CoreyyToken) {
        $b = B->string;
    } else {
        $b = (string) B;
    }
    A = new PHP_Parser_CoreyyToken(LIST->string . ', &' . $b, LIST);
    A[] = B;
}

global_var_list(A) ::= global_var_list(B) COMMA global_var(C). {
    A = B;
    A[] = C;
}
global_var_list(A) ::= global_var(B). {A = B;}

global_var(A) ::= T_VARIABLE(B). {A = new PHP_Parser_CoreyyToken(B, array('global' => B));}
global_var(A) ::= DOLLAR r_variable(B). {A = new PHP_Parser_CoreyyToken('$' . B->string, B);}
global_var(A) ::= DOLLAR LCURLY expr(B) RCURLY.{
    A = new PHP_Parser_CoreyyToken('${' . B->string . '}', B);
}


static_var_list(A) ::= static_var_list(B) COMMA T_VARIABLE(C). {
    A = new PHP_Parser_CoreyyToken('');
    A[] = B;
    A[] = array('static' => C, 'default' => null);
}
static_var_list(A) ::= static_var_list(B) COMMA T_VARIABLE(C) EQUALS static_scalar(D). {
    A = new PHP_Parser_CoreyyToken('');
    A[] = B;
    A[] = array('static' => C, 'default' => D);
}
static_var_list(A) ::= T_VARIABLE(B). {
    A = new PHP_Parser_CoreyyToken('', array('static' => B, 'default' => null));
}
static_var_list(A) ::= T_VARIABLE(B) EQUALS static_scalar(C). {
    A = new PHP_Parser_CoreyyToken('', array('static' => B, 'default' => C));
}

class_statement_list(A) ::= class_statement_list(list) class_statement(B). {
    A = list;
    A[] = B;
}
class_statement_list(A) ::= . {A = new PHP_Parser_CoreyyToken('');}

class_statement(A) ::= variable_modifiers(mod) class_variable_declaration(B) SEMI. {
    $a = array();
    foreach (B as $item) {
        $a[] = array(
            'type' => 'var',
            'name' => $item['name'],
            'line' => $item['line'],
            'default' => $item['default'],
            'modifiers' => mod,
            'doc' => $item['doc'],
            'parseddoc' => $item['parseddoc'],
            'docline' => $item['docline'],
        );
    }
    A = new PHP_Parser_CoreyyToken('', $a);
}
class_statement(A) ::= class_constant_declaration(B) SEMI. {
    $a = array();
    foreach (B as $item) {
        $a[] = array(
            'type' => 'const',
            'name' => $item['name'],
            'line' => $item['line'],
            'value' => $item['value'],
            'doc' => $item['doc'],
            'parseddoc' => $item['parseddoc'],
            'docline' => $item['docline'],
        );
    }
    A = new PHP_Parser_CoreyyToken('', $a);
}
get_method_line(A) ::= T_FUNCTION. {
    A = array($this->lex->line, $lastcom);
}
class_statement(A) ::= method_modifiers(mod) get_method_line(LINE) is_reference T_STRING(B) LPAREN parameter_list(params) RPAREN method_body(M). {
    list($doc, $parsed, $line) = LINE[1];
    A = new PHP_Parser_CoreyyToken('', array(
            array(
                'type' => 'method',
                'name' => B,
                'startline' => LINE[0],
                'endline' => $this->lex->line,
                'parameters' => params->metadata,
                'modifiers' => mod,
                'info' => M->metadata,
                'doc' => $doc,
                'parseddoc' => $parsed,
                'docline' => $line,
            )
        ));
}


method_body(A) ::= SEMI. /* abstract method */ {A = new PHP_Parser_CoreyyToken('');}
method_body(A) ::= LCURLY inner_statement_list(B) RCURLY. {
    A = B;
}

variable_modifiers(A) ::= non_empty_member_modifiers(B). {A = B;}
variable_modifiers(A) ::= T_VAR. {A = array('public');}

method_modifiers(A) ::= non_empty_member_modifiers(B). {A = B;}
method_modifiers(A) ::= . {A = array('public');}

non_empty_member_modifiers(A) ::= member_modifier(B). {A = array(B);}
non_empty_member_modifiers(A) ::= non_empty_member_modifiers(mod) member_modifier(B). {
    A = mod;
    A[] = B;
}

member_modifier(A) ::= T_PUBLIC|T_PROTECTED|T_PRIVATE|T_STATIC|T_ABSTRACT|T_FINAL(B). {A = strtolower(B);}

get_variable_line(A) ::= T_VARIABLE(B). {
    A = array(B, $this->lex->line);
}

class_variable_declaration(A) ::= class_variable_declaration(LIST) COMMA get_variable_line(var). {
    list($doc, $parsed, $line) = $this->lex->getLastComment();
    A = LIST;
    A[] = array(
        'name' => var[0],
        'default' => null,
        'line' => var[1],
        'doc' => $doc,
        'parseddoc' => $parsed,
        'docline' => $line,
    );
}
class_variable_declaration(A) ::= class_variable_declaration(LIST) COMMA get_variable_line(var) EQUALS static_scalar(val). {
    list($doc, $parsed, $line) = $this->lex->getLastComment();
    A = LIST;
    A[] = array(
        'name' => var[0],
        'default' => val,
        'line' => var[1],
        'doc' => $doc,
        'parseddoc' => $parsed,
        'docline' => $line,
    );
}
class_variable_declaration(A) ::= T_VARIABLE(B). {
    list($doc, $parsed, $line) = $this->lex->getLastComment();
    A = array(
            array(
                'name' => B,
                'default' => null,
                'line' => $this->lex->line,
                'doc' => $doc,
                'parseddoc' => $parsed,
                'docline' => $line,
            )
        );
}
class_variable_declaration(A) ::= get_variable_line(var) EQUALS static_scalar(val). {
    list($doc, $parsed, $line) = $this->lex->getLastComment();
    A = array(
            array(
                'name' => var[0],
                'default' => val,
                'line' => var[1],
                'doc' => $doc,
                'parseddoc' => $parsed,
                'docline' => $line,
            )
        );
}

get_constant_line(A) ::= T_STRING(B). {
    $doc = $this->lex->getLastComment();
    A = array(B, $this->lex->line, $doc);
}

class_constant_declaration(A) ::= class_constant_declaration(LIST) COMMA get_constant_line(n) EQUALS static_scalar(v). {
    A = LIST;
    list($doc, $parsed, $line) = n[2];
    A[] = array('name' => n[0], 'value' => v, 'line' => n[1],
       'doc' => $doc,
       'parseddoc' => $parsed,
       'docline' => $line,
    );
}
class_constant_declaration(A) ::= T_CONST get_constant_line(n) EQUALS static_scalar(v). {
    list($doc, $parsed, $line) = n[2];
    A = array(
        array('name' => n[0], 'value' => v, 'line' => n[1],
           'doc' => $doc,
           'parseddoc' => $parsed,
           'docline' => $line,
        )
    );
}

echo_expr_list(A) ::= echo_expr_list(B) COMMA expr(C). {A = B;A[] = C;}
echo_expr_list(A) ::= expr(B). {A = B;}

unset_variables(A) ::= unset_variable(B). {A = B;}
unset_variables(A) ::= unset_variables(B) COMMA unset_variable(C). {
    A = B;
    A[] = C;
}

unset_variable(A) ::= variable(B). {A = B;}

use_filename(A) ::= T_CONSTANT_ENCAPSED_STRING(B). {A = B;}
use_filename(A) ::= LPAREN T_CONSTANT_ENCAPSED_STRING(B) RPAREN. {
    A = '(' . B . ')';
}

r_variable(A) ::= variable(B). {A = B;}

w_variable(A) ::= variable(B). {A = B;}

rw_variable(A) ::= variable(B). {A = B;}

variable(A) ::= base_variable_with_function_calls(BASE) T_OBJECT_OPERATOR object_property(PROP) method_or_not(IS_METHOD) variable_properties(VARP). {
    A = new PHP_Parser_CoreyyToken(BASE->string . '->' . PROP->string .
        IS_METHOD->string . VARP->string, array());
    A[] = BASE;
    if (is_array(PROP)) {
        A[] = PROP;
    } else {
        if (IS_METHOD->string) {
            A[] = array(
                'uses' => 'method',
                'name' => trim(PROP),
            );
        } else {
            A[] = array(
                'uses' => 'var',
                'name' => trim(PROP),
            );
        }
    }
    A[] = VARP;
}
variable(A) ::= base_variable_with_function_calls(B). {A = B;}

variable_properties(A) ::= variable_properties(B) variable_property(C).
variable_properties(A) ::= . {A = new PHP_Parser_CoreyyToken('');}

variable_property(A) ::= T_OBJECT_OPERATOR object_property(B) method_or_not(C). {
    A = new PHP_Parser_CoreyyToken('->' . B->string . C->string, B);
    A[] = C;
}

method_or_not(A) ::= LPAREN function_call_parameter_list(B) RPAREN. {
    A = new PHP_Parser_CoreyyToken('(' . B . ')', B);
}
method_or_not(A) ::= . {A = new PHP_Parser_CoreyyToken('');}

variable_without_objects(A) ::= reference_variable(B). {A = B;}
variable_without_objects(A) ::= simple_indirect_reference(I) reference_variable(B). {
    A = new PHP_Parser_CoreyyToken(I . B->string, B);
}

static_member(A) ::= fully_qualified_class_name(CLASS) T_PAAMAYIM_NEKUDOTAYIM variable_without_objects(VAR). {
    A = new PHP_Parser_CoreyyToken(CLASS . '::' . VAR->string, array(
        array(
            'usedclass' => CLASS,
        )
    ));
    A[] = VAR;
}

base_variable_with_function_calls(A) ::= base_variable(B). {A = new PHP_Parser_CoreyyToken(B);}
base_variable_with_function_calls(A) ::= function_call(B). {A = B;}

base_variable(A) ::= reference_variable(B). {A = B;}
base_variable(A) ::= simple_indirect_reference(I) reference_variable(B). {
    A = new PHP_Parser_CoreyyToken(I . B->string, B);
}
base_variable(A) ::= static_member(B). {A = B;}
    
reference_variable(A) ::= reference_variable(REF) LBRACKET dim_offset(DIM) RBRACKET. {
    if (in_array(REF->string, array('$_GET', '$_POST', '$GLOBALS', '$_COOKIE', '$_REQUEST',
        '$_ENV', '$_FILES', '$_SERVER', '$HTTP_COOKIE_VARS', '$HTTP_ENV_VARS',
        '$HTTP_POST_FILES', '$HTTP_POST_VARS', '$HTTP_SERVER_VARS'))) {
        A = new PHP_Parser_CoreyyToken(REF->string . '[' . DIM->string . ']',
        array(
            array(
            'superglobal' => REF->string,
            'contents' => REF->string . '[' . DIM->string . ']'
        )));
    } else {
        A = new PHP_Parser_CoreyyToken(REF->string . '[' . DIM->string . ']', array());
    }
    A[] = REF;
    A[] = DIM;
}
reference_variable(A) ::= reference_variable(REF) LCURLY expr(DIM) RCURLY. {
    A = new PHP_Parser_CoreyyToken(REF->string . '{' . DIM->string . '}', array());
    A[] = REF;
    A[] = DIM;
}
reference_variable(A) ::= compound_variable(B). {A = new PHP_Parser_CoreyyToken(B);}

compound_variable(A) ::= T_VARIABLE(B). {A = B;}
compound_variable(A) ::= DOLLAR LCURLY expr(B) RCURLY. {A = new PHP_Parser_CoreyyToken('${' . B->string . '}', B);}

dim_offset(A) ::= expr(B). {A = new PHP_Parser_CoreyyToken(B);}
dim_offset(A) ::= . {A = new PHP_Parser_CoreyyToken('');}

object_property(A) ::= object_dim_list(B). {A = B;}
object_property(A) ::= variable_without_objects(B). {A = B;}

object_dim_list(A) ::= object_dim_list(LIST) LBRACKET dim_offset(B) RBRACKET. {
    A = new PHP_Parser_CoreyyToken(LIST->string . '[' . B->string . ']', LIST);
    A[] = B;
}
object_dim_list(A) ::= object_dim_list(LIST) LCURLY expr(B) RCURLY. {
    A = new PHP_Parser_CoreyyToken(LIST->string . '{' . B->string . '}', LIST);
    A[] = B;
}
object_dim_list(A) ::= variable_name(B). {A = new PHP_Parser_CoreyyToken(B);}

variable_name(A) ::= T_STRING(B). {A = B;}
variable_name(A) ::= LCURLY expr(B) RCURLY. {A = new PHP_Parser_CoreyyToken('{' . B->string . '}', B);}

simple_indirect_reference(A) ::= DOLLAR. {A = '$';}
simple_indirect_reference(A) ::= simple_indirect_reference(B) DOLLAR. {A = B . '$';}

assignment_list(A) ::= assignment_list(B) COMMA assignment_list_element(C). {
    A = new PHP_Parser_CoreyyToken(B->string . ', ' . C->string, B);
    A[] = C;
}
assignment_list(A) ::= assignment_list_element(B). {A = B;}

assignment_list_element(A) ::= variable(B). {A = B;}
assignment_list_element(A) ::= T_LIST LPAREN assignment_list(B) RPAREN. {
    A = new PHP_Parser_CoreyyToken('list(' . B->string . ')', B);
}
assignment_list_element(A) ::= . {A = new PHP_Parser_CoreyyToken('');}

array_pair_list(A) ::= non_empty_array_pair_list(B) possible_comma(C). {
    A = new PHP_Parser_CoreyyToken(B->string . C, B);
}
array_pair_list(A) ::= . {A = new PHP_Parser_CoreyyToken('');}

non_empty_array_pair_list(A) ::= expr(B) T_DOUBLE_ARROW AMPERSAND w_variable(C). {
    A = new PHP_Parser_CoreyyToken(B->string . ' => &' . C->string, B);
    A[] = C;
}
non_empty_array_pair_list(A) ::= expr(B). {A = B;}
non_empty_array_pair_list(A) ::= AMPERSAND w_variable(B). {
    A = new PHP_Parser_CoreyyToken('&' . B->string, B);
}
non_empty_array_pair_list(A) ::= non_empty_array_pair_list(B) COMMA expr(C) T_DOUBLE_ARROW expr(D). {
    A = new PHP_Parser_CoreyyToken(B->string . ', ' . C->string . ' => ' . D->string, B);
    A[] = C;
    A[] = D;
}
non_empty_array_pair_list(A) ::= non_empty_array_pair_list(B) COMMA expr(C). {
    A = new PHP_Parser_CoreyyToken(B->string . ', ' . C->string, B);
    A[] = C;
}
non_empty_array_pair_list(A) ::= expr(B) T_DOUBLE_ARROW expr(C). {
    A = new PHP_Parser_CoreyyToken(B->string . ' => ' . C->string, B);
    A[] = C;
}
non_empty_array_pair_list(A) ::= non_empty_array_pair_list(B) COMMA expr(C) T_DOUBLE_ARROW AMPERSAND w_variable(D). {
    A = new PHP_Parser_CoreyyToken(B->string . ', ' . C->string . ' => &' . D->string, B);
    A[] = C;
    A[] = D;
}
non_empty_array_pair_list(A) ::= non_empty_array_pair_list(B) COMMA AMPERSAND w_variable(C). {
    A = new PHP_Parser_CoreyyToken(B->string . ', &' . C->string, B);
    A[] = C;
}


encaps_list(A) ::= encaps_list(B) encaps_var(C). {
    A = new PHP_Parser_CoreyyToken(B->string . C, B);
    A[] = C;
}
encaps_list(A) ::= encaps_list(B) T_STRING(C). {
    A = new PHP_Parser_CoreyyToken(B->string . C, B);
}
encaps_list(A) ::= encaps_list(B) T_NUM_STRING(C). {
    A = new PHP_Parser_CoreyyToken(B->string . C, B);
}
encaps_list(A) ::= encaps_list(B) T_ENCAPSED_AND_WHITESPACE(C). {
    A = new PHP_Parser_CoreyyToken(B->string . C, B);
}
encaps_list(A) ::= encaps_list(B) T_CHARACTER(C). {
    A = new PHP_Parser_CoreyyToken(B->string . C, B);
}
encaps_list(A) ::= encaps_list(B) T_BAD_CHARACTER(C). {
    A = new PHP_Parser_CoreyyToken(B->string . C, B);
}
encaps_list(A) ::= encaps_list(B) LBRACKET. {
    A = new PHP_Parser_CoreyyToken(B->string . '[', B);
}
encaps_list(A) ::= encaps_list(B) RBRACKET. {
    A = new PHP_Parser_CoreyyToken(B->string . ']', B);
}
encaps_list(A) ::= encaps_list(B) LCURLY. {
    A = new PHP_Parser_CoreyyToken(B->string . '{', B);
}
encaps_list(A) ::= encaps_list(B) RCURLY. {
    A = new PHP_Parser_CoreyyToken(B->string . '}', B);
}
encaps_list(A) ::= encaps_list(B) T_OBJECT_OPERATOR. {
    A = new PHP_Parser_CoreyyToken(B->string . '->', B);
}
encaps_list(A) ::= . {A = new PHP_Parser_CoreyyToken('');}

encaps_var(A) ::= T_VARIABLE(B). {A = new PHP_Parser_CoreyyToken(B);}
encaps_var(A) ::= T_VARIABLE(B) LBRACKET T_STRING|T_NUM_STRING|T_VARIABLE(C) RBRACKET. {
    if (in_array(B, array('$_GET', '$_POST', '$GLOBALS', '$_COOKIE', '$_REQUEST',
        '$_ENV', '$_FILES', '$_SERVER', '$HTTP_COOKIE_VARS', '$HTTP_ENV_VARS',
        '$HTTP_POST_FILES', '$HTTP_POST_VARS', '$HTTP_SERVER_VARS'))) {
        A = new PHP_Parser_CoreyyToken(B . '[' . C . ']',
        array(
            array(
            'superglobal' => B,
            'contents' => C
        )));
    } else {
        A = new PHP_Parser_CoreyyToken(B . '[' . C . ']');
    }
}
encaps_var(A) ::= T_VARIABLE(B) T_OBJECT_OPERATOR T_STRING(C). {
    A = new PHP_Parser_CoreyyToken(B . '->' . C);
}
encaps_var(A) ::= T_DOLLAR_OPEN_CURLY_BRACES expr(B) RCURLY. {
    A = new PHP_Parser_CoreyyToken('${' . B->string . '}', B);
}
encaps_var(A) ::= T_DOLLAR_OPEN_CURLY_BRACES T_STRING_VARNAME(B) LBRACKET expr(C) RBRACKET RCURLY. {
    A = new PHP_Parser_CoreyyToken('${' . B . '[' . C->string . ']}', C);
}
encaps_var(A) ::= T_CURLY_OPEN variable(B) RCURLY. {
    A = new PHP_Parser_CoreyyToken('{' . B->string, '}', B);
}

internal_functions_in_yacc(A) ::= T_ISSET LPAREN isset_variables(B) RPAREN. {
    A = new PHP_Parser_CoreyyToken('isset(' . B->string . ')', B);
}
internal_functions_in_yacc(A) ::= T_EMPTY LPAREN variable(B) RPAREN. {
    A = new PHP_Parser_CoreyyToken('empty(' . B->string . ')', B);
}
get_include_line(A) ::= T_INCLUDE. {A=array($this->lex->line, $this->lex->getLastComment());}
internal_functions_in_yacc(A) ::= get_include_line(LINE) expr(B). {
    A = new PHP_Parser_CoreyyToken('include ' . B->string, B);
    list($doc, $parsed, $line) = LINE[1];
    A[] = array(
        'type' => 'include',
        'file' => B->string,
        'line' => LINE[0],
        'doc' => $doc,
        'parseddoc' => $parsed,
        'docline' => $line,
    );
    $this->includes[] = array(
        'type' => 'include',
        'file' => B->string,
        'line' => LINE[0],
        'doc' => $doc,
        'parseddoc' => $parsed,
        'docline' => $line,
    );
}
get_include_once_line(A) ::= T_INCLUDE_ONCE. {A=$this->lex->line;}
internal_functions_in_yacc(A) ::= get_include_once_line(LINE) expr(B). {
    A = new PHP_Parser_CoreyyToken('include_once ' . B->string, B);
    list($doc, $parsed, $line) = LINE[1];
    A[] = array(
        'type' => 'include_once',
        'file' => B->string,
        'line' => LINE[0],
        'doc' => $doc,
        'parseddoc' => $parsed,
        'docline' => $line,
    );
    $this->includes[] = array(
        'type' => 'include_once',
        'file' => B->string,
        'line' => LINE[0],
        'doc' => $doc,
        'parseddoc' => $parsed,
        'docline' => $line,
    );
}
internal_functions_in_yacc(A) ::= T_EVAL LPAREN expr(B) RPAREN. {
    A = new PHP_Parser_CoreyyToken('eval ' . B->string, B);
}
get_require_line(A) ::= T_REQUIRE. {A=array($this->lex->line, $this->lex->getLastComment());}
internal_functions_in_yacc(A) ::= get_require_line(LINE) expr(B). {
    list($doc, $parsed, $line) = LINE[1];
    A = new PHP_Parser_CoreyyToken('require ' . B->string, B);
    A[] = array(
        'type' => 'require',
        'file' => B->string,
        'line' => LINE[0],
        'doc' => $doc,
        'parseddoc' => $parsed,
        'docline' => $line,
    );
    $this->includes[] = array(
        'type' => 'require',
        'file' => B->string,
        'line' => LINE[0],
        'doc' => $doc,
        'parseddoc' => $parsed,
        'docline' => $line,
    );
}
get_require_once_line(A) ::= T_REQUIRE_ONCE. {A=array($this->lex->line,$this->lex->getLastComment());}
internal_functions_in_yacc(A) ::= get_require_once_line(LINE) expr(B). {
    list($doc, $parsed, $line) = LINE[1];
    A = new PHP_Parser_CoreyyToken('require_once ' . B->string, B);
    A[] = array(
        'type' => 'require_once',
        'file' => B->string,
        'line' => LINE[0],
        'doc' => $doc,
        'parseddoc' => $parsed,
        'docline' => $line,
    );
    $this->includes[] = array(
        'type' => 'require_once',
        'file' => B->string,
        'line' => LINE[0],
        'doc' => $doc,
        'parseddoc' => $parsed,
        'docline' => $line,
    );
}

isset_variables(A) ::= variable(B). {A = B;}
isset_variables(A) ::= isset_variables(B) COMMA variable(C). {
    A = new PHP_Parser_CoreyyToken(B->string . ', ' . C->string, B);
    A[] = C;
}

class_constant(A) ::= fully_qualified_class_name(B) T_PAAMAYIM_NEKUDOTAYIM T_STRING(C). {
    A = new PHP_Parser_CoreyyToken(B . '::' . C, array('usedclass' => B));
    A[] = array('usedclassconstant' => B . '::' . C);
}

fully_qualified_class_name(A) ::= T_STRING(B). {A = B;}

function_call(A) ::= T_STRING(B) LPAREN function_call_parameter_list(C) RPAREN. {A = new PHP_Parser_CoreyyToken(B . '(' . C->string . ')', C);}
function_call(A) ::= fully_qualified_class_name(CLAS) T_PAAMAYIM_NEKUDOTAYIM T_STRING(FUNC) LPAREN function_call_parameter_list(PL) RPAREN. {
    A = new PHP_Parser_CoreyyToken(CLAS . '::' . FUNC . '(' . PL->string . ')',
            PL);
    A[] = array(
        'uses' => 'class',
        'name' => trim(CLAS),
    );
    A[] = array(
        'uses' => 'method',
        'class' => trim(CLAS),
        'name' => trim(FUNC),
    );
}
function_call(A) ::= fully_qualified_class_name(CLAS) T_PAAMAYIM_NEKUDOTAYIM variable_without_objects(V) LPAREN function_call_parameter_list(PL) RPAREN. {
    A = new PHP_Parser_CoreyyToken(CLAS . '::' . V->string . '(' . PL->string . ')', V);
    A[] = PL;
    A[] = array(
        'uses' => 'class',
        'name' => trim(CLAS),
    );
}
function_call(A) ::= variable_without_objects(B) LPAREN function_call_parameter_list(PL) RPAREN. {
    A = new PHP_Parser_CoreyyToken(B->string . '(' . PL->string . ')', B);
    A[] = PL;
}

scalar(A) ::= T_STRING(B). {A = new PHP_Parser_CoreyyToken(B);}
scalar(A) ::= T_STRING_VARNAME(B). {A = new PHP_Parser_CoreyyToken(B);}
scalar(A) ::= class_constant(B). {A = new PHP_Parser_CoreyyToken(B);}
scalar(A) ::= common_scalar(B). {A = new PHP_Parser_CoreyyToken(B);}
scalar(A) ::= DOUBLEQUOTE encaps_list(B) DOUBLEQUOTE. {
    A = new PHP_Parser_CoreyyToken('"' . B->string . '"', B);
}
scalar(A) ::= SINGLEQUOTE encaps_list(B) SINGLEQUOTE. {
    A = new PHP_Parser_CoreyyToken("'" . B->string . "'", B);
}
scalar(A) ::= T_START_HEREDOC(HERE) encaps_list(B) T_END_HEREDOC(DOC). {
    A = new PHP_Parser_CoreyyToken(HERE->string . B->string . DOC->string, B);
}

class_name_reference(A) ::= T_STRING(B). {A = B;}
class_name_reference(A) ::= dynamic_class_name_reference(B). {A = B;}

dynamic_class_name_reference(A) ::= base_variable(B) T_OBJECT_OPERATOR object_property(C) dynamic_class_name_variable_properties(D). {
    A = new PHP_Parser_CoreyyToken(B->string . '->' . C->string . D->string, B);
    A[] = array('usedmember' => array(B->string, C->string));
    A[] = D;
}
dynamic_class_name_reference(A) ::= base_variable(B). {A = B;}

dynamic_class_name_variable_properties(A) ::= dynamic_class_name_variable_properties(B) dynamic_class_name_variable_property(C). {
    A = B;
    B[] = C;
}
dynamic_class_name_variable_properties(A) ::= . {A = new PHP_Parser_CoreyyToken('');}

dynamic_class_name_variable_property(A) ::= T_OBJECT_OPERATOR object_property(B). {
    A = new PHP_Parser_CoreyyToken('->' . B->string, array('usedmember' => B->string));
}

ctor_arguments(A) ::= LPAREN function_call_parameter_list(B) RPAREN. {
    A = new PHP_Parser_CoreyyToken('(' . B->string . ')', B);
}
ctor_arguments(A) ::= . {A = new PHP_Parser_CoreyyToken('');}

possible_comma(A) ::= COMMA. {A = ',';}
possible_comma(A) ::= . {A = '';}

for_expr(A) ::= non_empty_for_expr(B). {A = B;}
for_expr(A) ::= . {A = new PHP_Parser_CoreyyToken('');}

non_empty_for_expr(A) ::= non_empty_for_expr(B) COMMA expr(C). {
    A = new PHP_Parser_CoreyyToken(B->string . ', ' . C->string, B);
    A[] = C;
}
non_empty_for_expr(A) ::= expr(B). {A = B;}

is_reference(A) ::= AMPERSAND. {A = true;}
is_reference(A) ::= . {A = false;}