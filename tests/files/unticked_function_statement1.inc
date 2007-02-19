<?php
//unticked_function_declaration_statement(A) ::=
//		T_FUNCTION is_reference(ref) T_STRING(funcname) LPAREN parameter_list(params) RPAREN
//		LCURLY inner_statement_list(funcinfo) RCURLY. {
//parameter_list(A) ::= .
function test(){}
function &test(){}

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

?>