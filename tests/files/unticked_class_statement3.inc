<?php
//unticked_class_declaration_statement(A) ::=
//		interface_entry T_STRING(B)
//			interface_extends_list(C)
//			LCURLY
//				class_statement_list(D)
//			RCURLY. {
//interface_extends_list(A) ::= .

interface blah
{
    const a = 1;
    function a();
    function b(Foo $a, Arp &$b = null, $c = array());
}
?>