<?php
//unticked_class_declaration_statement(A) ::=
//		class_entry_type(classtype) T_STRING(C) extends_from(ext)
//			implements_list(impl)
//			LCURLY
//				class_statement_list(cinfo)
//			RCURLY. {

//extends_from(A) ::= .
//implements_list(A) ::= .
//class_statement_list(A) ::= .
//class_entry_type(A) ::= T_CLASS.
class foo{}
//class_entry_type(A) ::= T_ABSTRACT T_CLASS.
abstract class foo{}
//class_entry_type(A) ::= T_FINAL T_CLASS.
final class foo{}

//extends_from(A) ::= T_EXTENDS fully_qualified_class_name(B).
class foo extends bah{}

//implements_list(A) ::= T_IMPLEMENTS interface_list(B).
//interface_list(A) ::= fully_qualified_class_name(B).
//fully_qualified_class_name(A) ::= T_STRING(B).
class foo implements bor{}
//interface_list(A) ::= interface_list(list) COMMA fully_qualified_class_name(B).
class foo implements bor, boo{}

//class_statement_list(A) ::= class_statement_list(list) class_statement(B).
class foo
{
//class_statement(A) ::= variable_modifiers(mod) class_variable_declaration(B) SEMI.
//variable_modifiers(A) ::= T_VAR.
//class_variable_declaration(A) ::= T_VARIABLE(B).
var $a;
//class_variable_declaration(A) ::= T_VARIABLE(var) EQUALS static_scalar(val).
var $a = 1;
//variable_modifiers(A) ::= non_empty_member_modifiers(B).
//non_empty_member_modifiers(A) ::= member_modifier(B).
//non_empty_member_modifiers(A) ::= non_empty_member_modifiers(mod) member_modifier(B).
//member_modifier(A) ::= T_PUBLIC|T_PROTECTED|T_PRIVATE|T_STATIC|T_ABSTRACT|T_FINAL(B).
public $a;
private public $a; // weird that this isn't E_PARSE, but is instead E_COMPILE
static protected $a;
public final $a;
public abstract $a;
//class_variable_declaration(A) ::= class_variable_declaration(list) COMMA T_VARIABLE(var).
static private $a, $b;
//class_variable_declaration(A) ::= class_variable_declaration(list) COMMA T_VARIABLE(var) EQUALS static_scalar(val).
abstract public $a, $b = 1;

//class_statement(A) ::= class_constant_declaration(B) SEMI.
//class_constant_declaration(A) ::= T_CONST T_STRING(n) EQUALS static_scalar(v).
const hi = array(1 => 2);
//class_constant_declaration(A) ::= class_constant_declaration(list) COMMA T_STRING(n) EQUALS static_scalar(v).
const bye = 1, helloagain = 'matey';

//class_statement(A) ::= method_modifiers(mod) T_FUNCTION is_reference T_STRING(B) LPAREN parameter_list(params) RPAREN method_body.
//method_modifiers(A) ::= .
//method_body(A) ::= SEMI.
//method_modifiers(A) ::= .
//is_reference(A) ::= . {A = false;}
function test();
//is_reference(A) ::= AMPERSAND. {A = true;}
function &test();
//method_body(A) ::= LCURLY inner_statement_list(B) RCURLY.
function test(){}
//method_modifiers(A) ::= non_empty_member_modifiers(B).
public private static protected abstract final function test(){}
//non_empty_parameter_list(A) ::= optional_class_type(T) T_VARIABLE(V).
function test($a){}
//optional_class_type(A) ::= T_STRING|T_ARRAY(B).
function test(Foo $a){}
function test(array $a){}
//non_empty_parameter_list(A) ::= optional_class_type(T) AMPERSAND T_VARIABLE(V).
function test(&$a){}
function test(Foo &$a){}
function test(array &$a){}
//non_empty_parameter_list(A) ::= optional_class_type(T) AMPERSAND T_VARIABLE(V) EQUALS static_scalar(D). {
function test(&$a = 1){}
function test(Foo &$a = null){}
function test(array &$a = array()){}
//non_empty_parameter_list(A) ::= optional_class_type(T) T_VARIABLE(V) EQUALS static_scalar(D). {
function test($a = 1){}
function test(Foo $a = 2){}
function test(array $a = null){}
//non_empty_parameter_list(A) ::= non_empty_parameter_list(list) COMMA optional_class_type(T) T_VARIABLE(V). {
function test($a, $b){}
function test($a, Foo $b){}
function test($a, array $b){}
//non_empty_parameter_list(A) ::= non_empty_parameter_list(list) COMMA optional_class_type(T) AMPERSAND T_VARIABLE(V). {
function test($a, &$b){}
function test($a, Foo &$b){}
function test($a, array &$b){}
//non_empty_parameter_list(A) ::= non_empty_parameter_list(list) COMMA optional_class_type(T) AMPERSAND T_VARIABLE(V) EQUALS static_scalar(D). {
function test($a, &$b = 1){}
function test($a, Foo &$b = 2){}
function test($a, array &$b = 3){}
//non_empty_parameter_list(A) ::= non_empty_parameter_list(list) COMMA optional_class_type(T) T_VARIABLE(V) EQUALS static_scalar(D). {
function test($a, $b = 1){}
function test($a, Foo $b = 2){}
function test($a, array $b = 3){}

}
?>