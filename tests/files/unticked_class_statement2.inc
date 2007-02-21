<?php
class test {
//method_body(A) ::= LCURLY inner_statement_list(B) RCURLY.
function test()
{
//inner_statement_list(A) ::= .    
}
function test()
{
//inner_statement(A) ::= statement(B).
// unticked_statement(A) ::= LCURLY inner_statement_list(B) RCURLY. {A = B;}
{}
// unticked_statement(A) ::= T_IF LPAREN expr(E) RPAREN statement(I) elseif_list(EL) else_single(ELL)
//elseif_list(A) ::= .
//else_single(A) ::= .
if (1);
//elseif_list(A) ::= .
//else_single(A) ::= T_ELSE statement(B). {A = B;}
if (1); else;
//else_single(A) ::= .
//elseif_list(A) ::= elseif_list(B) T_ELSEIF LPAREN expr(C) RPAREN statement(D). {
if (1); elseif (2);
//elseif_list(A) ::= elseif_list(B) T_ELSEIF LPAREN expr(C) RPAREN statement(D). {
//else_single(A) ::= .
if (1); elseif (2); elseif (3);
//elseif_list(A) ::= elseif_list(B) T_ELSEIF LPAREN expr(C) RPAREN statement(D). {
//else_single(A) ::= T_ELSE statement(B). {A = B;}
if (1); elseif (2); elseif (3); else(4);

//unticked_statement(A) ::= T_IF LPAREN expr(E) RPAREN COLON inner_statement_list(I) new_elseif_list(EL) new_else_single(ELL) T_ENDIF SEMI. {
//new_else_single(A) ::= .
//new_elseif_list(A) ::= .
if (1):endif;
//new_else_single(A) ::= T_ELSE COLON inner_statement_list(B). {A = B;}
//new_elseif_list(A) ::= .
if (1):else:endif;
//new_else_single(A) ::= .
//new_elseif_list(A) ::= new_elseif_list(B) T_ELSEIF LPAREN expr(C) RPAREN COLON inner_statement_list(D) . {
if (1):elseif(2):endif;
//new_else_single(A) ::= T_ELSE COLON inner_statement_list(B). {A = B;}
//new_elseif_list(A) ::= .
if (1):elseif(2):else:endif;

//unticked_statement(A) ::= T_WHILE LPAREN expr(B) RPAREN while_statement(C). {
//while_statement(A) ::= statement(B).
while(1);
//while_statement(A) ::= COLON inner_statement_list(B) T_ENDWHILE SEMI.
while(1):endwhile;

//unticked_statement(A) ::= T_DO statement(B) T_WHILE LPAREN expr(C) RPAREN SEMI. {
do;while(1);

//unticked_statement(A) ::= T_FOR 
//			LPAREN
//				for_expr(B)
//			SEMI 
//				for_expr(C)
//			SEMI
//				for_expr(D)
//			RPAREN
//			for_statement(E). {
for(;;);
//for_statement(A) ::= COLON inner_statement_list(B) T_ENDFOR SEMI. {A = B;}
for(;;):endfor;
//non_empty_for_expr(A) ::= non_empty_for_expr(B) COMMA expr(C). {
for(1,1,1;2,2,2;);

//unticked_statement(A) ::= T_SWITCH LPAREN expr(B) RPAREN switch_case_list(C). {
//switch_case_list(A) ::= LCURLY case_list(B) RCURLY. {A = B;}
//case_list(A) ::= .
switch(1){}
//switch_case_list(A) ::= LCURLY SEMI case_list(B) RCURLY. {A = B;}
//case_list(A) ::= .
switch(1){;}
//switch_case_list(A) ::= COLON case_list(B) T_ENDSWITCH SEMI. {A = B;}
//case_list(A) ::= .
switch(1):endswitch;
//switch_case_list(A) ::= COLON SEMI case_list(B) T_ENDSWITCH SEMI. {A = B;}
//case_list(A) ::= .
switch(1):;endswitch;
//switch_case_list(A) ::= LCURLY case_list(B) RCURLY. {A = B;}
//case_list(A) ::= case_list(LIST) T_CASE expr(B) case_separator inner_statement_list(C).
switch(1){case 1;}
switch(1){case 1:}
//case_list(A) ::= case_list(LIST) T_DEFAULT case_separator inner_statement_list(B). {
switch(1){default:}

//switch_case_list(A) ::= LCURLY case_list(B) RCURLY. {A = B;}
//case_list(A) ::= case_list(LIST) T_CASE expr(B) case_separator inner_statement_list(C).
switch(1){case 1;case 2:}
switch(1){case 1:case 2;}
switch(1){case 1:default;}
switch(1){case 1:default:}

//unticked_statement ::= T_BREAK SEMI.
break;
//unticked_statement(A) ::= T_BREAK expr(B) SEMI. {
break 2;
//unticked_statement ::= T_CONTINUE SEMI.
continue;
//unticked_statement ::= T_CONTINUE expr(B) SEMI. {
continue 2;

//unticked_statement ::= T_RETURN SEMI.
return;
//unticked_statement(A) ::= T_RETURN expr_without_variable(B) SEMI. {
return 3;
//unticked_statement(A) ::= T_RETURN variable(B) SEMI. {
return $a;

//unticked_statement(A) ::= T_GLOBAL global_var_list(B) SEMI. {A = B;}

//global_var_list(A) ::= global_var(B). {A = B;}
//global_var(A) ::= T_VARIABLE(B). {A = new PHP_Parser_CoreyyToken(B, array('global' => B));}
global $a;
//global_var(A) ::= DOLLAR r_variable(B). {A = new PHP_Parser_CoreyyToken('$' . B);}
global $$a;
//global_var(A) ::= DOLLAR LCURLY expr(B) RCURLY.{
global ${1};
//global_var_list(A) ::= global_var_list(B) COMMA global_var(C). {
global $a, $$a, ${1};

//unticked_statement(A) ::= T_STATIC static_var_list(B) SEMI. {A = B;}
//static_var_list(A) ::= T_VARIABLE(B). {
static $a;
//static_var_list(A) ::= T_VARIABLE(B) EQUALS static_scalar(C). {
static $a = 1;
//static_var_list(A) ::= static_var_list(B) COMMA T_VARIABLE(C) EQUALS static_scalar(D). {
static $a,$b = 1;
//static_var_list(A) ::= static_var_list(B) COMMA T_VARIABLE(C). {
static $a,$b;

//unticked_statement(A) ::= T_ECHO echo_expr_list(B) SEMI. {
//echo_expr_list(A) ::= expr(B). {A = B;}
echo 1;
//echo_expr_list(A) ::= echo_expr_list(B) COMMA expr(C). {A = B;A[] = C;}
echo 1,2;

//unticked_statement ::= T_INLINE_HTML.
?>hi<?php

//unticked_statement(A) ::= expr(B) SEMI. {A = B;}
1;

//unticked_statement(A) ::= T_USE use_filename(B) SEMI. {
//use_filename(A) ::= T_CONSTANT_ENCAPSED_STRING(B). {A = B;}
use 'hi';
//use_filename(A) ::= LPAREN T_CONSTANT_ENCAPSED_STRING(B) RPAREN. {
use ('hi');

//unticked_statement(A) ::= T_UNSET LPAREN unset_variables(B) LPAREN SEMI. {
//unset_variables(A) ::= unset_variable(B). {A = B;}
unset($a);
//unset_variables(A) ::= unset_variables(B) COMMA unset_variable(C). {
unset($a, $b);

//unticked_statement(A) ::= T_FOREACH LPAREN variable(B) T_AS 
//		foreach_variable foreach_optional_arg RPAREN
//		foreach_statement(C). {
//foreach_variable ::= w_variable.
//foreach_optional_arg ::= .
//foreach_statement(A) ::= statement(B). {A = B;}
foreach ($a as $b);
//foreach_statement(A) ::= COLON inner_statement_list(B) T_ENDFOREACH SEMI. {A = B;}
foreach ($a as $b):endforeach;
//foreach_variable ::= AMPERSAND w_variable.
//foreach_optional_arg ::= T_DOUBLE_ARROW foreach_variable.
//foreach_statement(A) ::= statement(B). {A = B;}
foreach ($a as $b => $c);
//foreach_statement(A) ::= COLON inner_statement_list(B) T_ENDFOREACH SEMI. {A = B;}
foreach ($a as $b => $c):endforeach;
//unticked_statement(A) ::= T_FOREACH LPAREN expr_without_variable(B) T_AS 
//		w_variable foreach_optional_arg RPAREN
//		foreach_statement(C). {
//foreach_variable ::= w_variable.
//foreach_optional_arg ::= .
//foreach_statement(A) ::= statement(B). {A = B;}
foreach (array() as $b);
foreach (array() as $b => $c);
//foreach_statement(A) ::= COLON inner_statement_list(B) T_ENDFOREACH SEMI. {A = B;}
foreach (array() as $b):endforeach;
foreach (array() as $b => $c):endforeach;
//foreach_variable ::= AMPERSAND w_variable.
//foreach_statement(A) ::= statement(B). {A = B;}
foreach (array() as $b => &$c);
//foreach_statement(A) ::= COLON inner_statement_list(B) T_ENDFOREACH SEMI. {A = B;}
foreach (array() as $b):endforeach;
//foreach_variable ::= AMPERSAND w_variable.
//foreach_optional_arg ::= T_DOUBLE_ARROW foreach_variable.
foreach (array() as $b => &$c):endforeach;

//unticked_statement(A) ::= T_DECLARE LPAREN declare_list(B) RPAREN declare_statement(C).
//declare_list(A) ::= T_STRING(B) EQUALS static_scalar(C).
declare(hi = 1);
//declare_statement(A) ::= COLON inner_statement_list(B) T_ENDDECLARE SEMI.
declare(hi = 1):enddeclare;
//declare_list(A) ::= declare_list(DEC) COMMA T_STRING(B) EQUALS static_scalar(C).
declare(hit = 2, bye = 3);
//declare_statement(A) ::= COLON inner_statement_list(B) T_ENDDECLARE SEMI.
declare(hit = 2, bye = 3):enddeclare;

//unticked_statement ::= SEMI.
;

//unticked_statement(A) ::= T_TRY LCURLY inner_statement_list(B) RCURLY
//		T_CATCH LPAREN
//		fully_qualified_class_name(C)
//		T_VARIABLE RPAREN
//		LCURLY inner_statement_list(D) RCURLY
//		additional_catches(E). {
//additional_catches ::= .
try {} catch (Blah $a) {}
//additional_catches(A) ::= non_empty_additional_catches(B). {A = B;}
//non_empty_additional_catches(A) ::= additional_catch(B). {A = B;}
//additional_catch(A) ::= T_CATCH LPAREN fully_qualified_class_name(B) T_VARIABLE RPAREN LCURLY inner_statement_list(C) RCURLY. {
try {} catch (Blah $a) {} catch (Foo $b) {}

//unticked_statement(A) ::= T_THROW expr(B) SEMI. {
throw 1;
throw $a;
throw new Classname;
function inside(){}
class inside{}
interface inside{}
}
}
?>