--TEST--
PHP_Parser: test unticked_class_statement 1
--FILE--
<?php
require_once 'PHP/Parser/Core.php';
require_once 'PHP/Parser/Tokenizer.php';
$a = new PHP_Parser_Tokenizer(file_get_contents(dirname(__FILE__) . '/files/unticked_class_statement1.inc'));
$b = new PHP_Parser_Core($a);
while ($a->advance()) {
    $b->doParse($a->token, $a->getValue(), $a);
}
$b->doParse(0, 0);
var_dump($b->data);
var_dump($b->classes);
var_dump($b->interfaces);
var_dump($b->functions);
var_dump($b->includes);
var_dump($b->globals);
?>
===DONE===
--EXPECT--
array(7) {
  [0]=>
  array(11) {
    ["type"]=>
    string(5) "class"
    ["startline"]=>
    int(13)
    ["endline"]=>
    int(15)
    ["modifiers"]=>
    array(0) {
    }
    ["name"]=>
    string(3) "foo"
    ["extends"]=>
    array(0) {
    }
    ["implements"]=>
    array(0) {
    }
    ["info"]=>
    array(0) {
    }
    ["doc"]=>
    NULL
    ["parseddoc"]=>
    NULL
    ["docline"]=>
    NULL
  }
  [1]=>
  array(11) {
    ["type"]=>
    string(5) "class"
    ["startline"]=>
    int(15)
    ["endline"]=>
    int(17)
    ["modifiers"]=>
    array(1) {
      [0]=>
      string(8) "abstract"
    }
    ["name"]=>
    string(3) "foo"
    ["extends"]=>
    array(0) {
    }
    ["implements"]=>
    array(0) {
    }
    ["info"]=>
    array(0) {
    }
    ["doc"]=>
    string(0) ""
    ["parseddoc"]=>
    bool(false)
    ["docline"]=>
    int(-1)
  }
  [2]=>
  array(11) {
    ["type"]=>
    string(5) "class"
    ["startline"]=>
    int(17)
    ["endline"]=>
    int(20)
    ["modifiers"]=>
    array(1) {
      [0]=>
      string(5) "final"
    }
    ["name"]=>
    string(3) "foo"
    ["extends"]=>
    array(0) {
    }
    ["implements"]=>
    array(0) {
    }
    ["info"]=>
    array(0) {
    }
    ["doc"]=>
    string(0) ""
    ["parseddoc"]=>
    bool(false)
    ["docline"]=>
    int(-1)
  }
  [3]=>
  array(11) {
    ["type"]=>
    string(5) "class"
    ["startline"]=>
    int(20)
    ["endline"]=>
    int(25)
    ["modifiers"]=>
    array(0) {
    }
    ["name"]=>
    string(3) "foo"
    ["extends"]=>
    array(1) {
      [0]=>
      string(3) "bah"
    }
    ["implements"]=>
    array(0) {
    }
    ["info"]=>
    array(0) {
    }
    ["doc"]=>
    string(0) ""
    ["parseddoc"]=>
    bool(false)
    ["docline"]=>
    int(-1)
  }
  [4]=>
  array(11) {
    ["type"]=>
    string(5) "class"
    ["startline"]=>
    int(25)
    ["endline"]=>
    int(27)
    ["modifiers"]=>
    array(0) {
    }
    ["name"]=>
    string(3) "foo"
    ["extends"]=>
    array(0) {
    }
    ["implements"]=>
    array(1) {
      [0]=>
      string(3) "bor"
    }
    ["info"]=>
    array(0) {
    }
    ["doc"]=>
    string(0) ""
    ["parseddoc"]=>
    bool(false)
    ["docline"]=>
    int(-1)
  }
  [5]=>
  array(11) {
    ["type"]=>
    string(5) "class"
    ["startline"]=>
    int(27)
    ["endline"]=>
    int(30)
    ["modifiers"]=>
    array(0) {
    }
    ["name"]=>
    string(3) "foo"
    ["extends"]=>
    array(0) {
    }
    ["implements"]=>
    array(2) {
      [0]=>
      string(3) "bor"
      [1]=>
      string(3) "boo"
    }
    ["info"]=>
    array(0) {
    }
    ["doc"]=>
    string(0) ""
    ["parseddoc"]=>
    bool(false)
    ["docline"]=>
    int(-1)
  }
  [6]=>
  array(11) {
    ["type"]=>
    string(5) "class"
    ["startline"]=>
    int(30)
    ["endline"]=>
    int(105)
    ["modifiers"]=>
    array(0) {
    }
    ["name"]=>
    string(3) "foo"
    ["extends"]=>
    array(0) {
    }
    ["implements"]=>
    array(0) {
    }
    ["info"]=>
    array(42) {
      [0]=>
      array(8) {
        ["type"]=>
        string(3) "var"
        ["name"]=>
        string(2) "$a"
        ["line"]=>
        int(35)
        ["default"]=>
        NULL
        ["modifiers"]=>
        array(1) {
          [0]=>
          string(6) "public"
        }
        ["doc"]=>
        string(0) ""
        ["parseddoc"]=>
        bool(false)
        ["docline"]=>
        int(-1)
      }
      [1]=>
      array(8) {
        ["type"]=>
        string(3) "var"
        ["name"]=>
        string(2) "$a"
        ["line"]=>
        int(37)
        ["default"]=>
        string(1) "1"
        ["modifiers"]=>
        array(1) {
          [0]=>
          string(6) "public"
        }
        ["doc"]=>
        string(0) ""
        ["parseddoc"]=>
        bool(false)
        ["docline"]=>
        int(-1)
      }
      [2]=>
      array(8) {
        ["type"]=>
        string(3) "var"
        ["name"]=>
        string(2) "$a"
        ["line"]=>
        int(42)
        ["default"]=>
        NULL
        ["modifiers"]=>
        array(1) {
          [0]=>
          string(6) "public"
        }
        ["doc"]=>
        string(0) ""
        ["parseddoc"]=>
        bool(false)
        ["docline"]=>
        int(-1)
      }
      [3]=>
      array(8) {
        ["type"]=>
        string(3) "var"
        ["name"]=>
        string(2) "$a"
        ["line"]=>
        int(43)
        ["default"]=>
        NULL
        ["modifiers"]=>
        array(2) {
          [0]=>
          string(7) "private"
          [1]=>
          string(6) "public"
        }
        ["doc"]=>
        string(0) ""
        ["parseddoc"]=>
        bool(false)
        ["docline"]=>
        int(-1)
      }
      [4]=>
      array(8) {
        ["type"]=>
        string(3) "var"
        ["name"]=>
        string(2) "$a"
        ["line"]=>
        int(44)
        ["default"]=>
        NULL
        ["modifiers"]=>
        array(2) {
          [0]=>
          string(6) "static"
          [1]=>
          string(9) "protected"
        }
        ["doc"]=>
        string(0) ""
        ["parseddoc"]=>
        bool(false)
        ["docline"]=>
        int(-1)
      }
      [5]=>
      array(8) {
        ["type"]=>
        string(3) "var"
        ["name"]=>
        string(2) "$a"
        ["line"]=>
        int(45)
        ["default"]=>
        NULL
        ["modifiers"]=>
        array(2) {
          [0]=>
          string(6) "public"
          [1]=>
          string(5) "final"
        }
        ["doc"]=>
        string(0) ""
        ["parseddoc"]=>
        bool(false)
        ["docline"]=>
        int(-1)
      }
      [6]=>
      array(8) {
        ["type"]=>
        string(3) "var"
        ["name"]=>
        string(2) "$a"
        ["line"]=>
        int(46)
        ["default"]=>
        NULL
        ["modifiers"]=>
        array(2) {
          [0]=>
          string(6) "public"
          [1]=>
          string(8) "abstract"
        }
        ["doc"]=>
        string(0) ""
        ["parseddoc"]=>
        bool(false)
        ["docline"]=>
        int(-1)
      }
      [7]=>
      array(8) {
        ["type"]=>
        string(3) "var"
        ["name"]=>
        string(2) "$a"
        ["line"]=>
        int(48)
        ["default"]=>
        NULL
        ["modifiers"]=>
        array(2) {
          [0]=>
          string(6) "static"
          [1]=>
          string(7) "private"
        }
        ["doc"]=>
        string(0) ""
        ["parseddoc"]=>
        bool(false)
        ["docline"]=>
        int(-1)
      }
      [8]=>
      array(8) {
        ["type"]=>
        string(3) "var"
        ["name"]=>
        string(2) "$b"
        ["line"]=>
        int(48)
        ["default"]=>
        NULL
        ["modifiers"]=>
        array(2) {
          [0]=>
          string(6) "static"
          [1]=>
          string(7) "private"
        }
        ["doc"]=>
        string(0) ""
        ["parseddoc"]=>
        bool(false)
        ["docline"]=>
        int(-1)
      }
      [9]=>
      array(8) {
        ["type"]=>
        string(3) "var"
        ["name"]=>
        string(2) "$a"
        ["line"]=>
        int(50)
        ["default"]=>
        NULL
        ["modifiers"]=>
        array(2) {
          [0]=>
          string(8) "abstract"
          [1]=>
          string(6) "public"
        }
        ["doc"]=>
        string(0) ""
        ["parseddoc"]=>
        bool(false)
        ["docline"]=>
        int(-1)
      }
      [10]=>
      array(8) {
        ["type"]=>
        string(3) "var"
        ["name"]=>
        string(2) "$b"
        ["line"]=>
        int(50)
        ["default"]=>
        string(1) "1"
        ["modifiers"]=>
        array(2) {
          [0]=>
          string(8) "abstract"
          [1]=>
          string(6) "public"
        }
        ["doc"]=>
        string(0) ""
        ["parseddoc"]=>
        bool(false)
        ["docline"]=>
        int(-1)
      }
      [11]=>
      array(7) {
        ["type"]=>
        string(5) "const"
        ["name"]=>
        string(2) "hi"
        ["line"]=>
        int(54)
        ["value"]=>
        string(13) "array(1 => 2)"
        ["doc"]=>
        string(0) ""
        ["parseddoc"]=>
        bool(false)
        ["docline"]=>
        int(-1)
      }
      [12]=>
      array(7) {
        ["type"]=>
        string(5) "const"
        ["name"]=>
        string(3) "bye"
        ["line"]=>
        int(56)
        ["value"]=>
        string(1) "1"
        ["doc"]=>
        string(0) ""
        ["parseddoc"]=>
        bool(false)
        ["docline"]=>
        int(-1)
      }
      [13]=>
      array(7) {
        ["type"]=>
        string(5) "const"
        ["name"]=>
        string(10) "helloagain"
        ["line"]=>
        int(56)
        ["value"]=>
        string(7) "'matey'"
        ["doc"]=>
        string(0) ""
        ["parseddoc"]=>
        bool(false)
        ["docline"]=>
        int(-1)
      }
      [14]=>
      array(10) {
        ["type"]=>
        string(6) "method"
        ["name"]=>
        string(4) "test"
        ["startline"]=>
        int(63)
        ["endline"]=>
        int(65)
        ["parameters"]=>
        array(0) {
        }
        ["modifiers"]=>
        array(1) {
          [0]=>
          string(6) "public"
        }
        ["info"]=>
        array(0) {
        }
        ["doc"]=>
        NULL
        ["parseddoc"]=>
        NULL
        ["docline"]=>
        NULL
      }
      [15]=>
      array(10) {
        ["type"]=>
        string(6) "method"
        ["name"]=>
        string(4) "test"
        ["startline"]=>
        int(65)
        ["endline"]=>
        int(67)
        ["parameters"]=>
        array(0) {
        }
        ["modifiers"]=>
        array(1) {
          [0]=>
          string(6) "public"
        }
        ["info"]=>
        array(0) {
        }
        ["doc"]=>
        NULL
        ["parseddoc"]=>
        NULL
        ["docline"]=>
        NULL
      }
      [16]=>
      array(10) {
        ["type"]=>
        string(6) "method"
        ["name"]=>
        string(4) "test"
        ["startline"]=>
        int(67)
        ["endline"]=>
        int(69)
        ["parameters"]=>
        array(0) {
        }
        ["modifiers"]=>
        array(1) {
          [0]=>
          string(6) "public"
        }
        ["info"]=>
        array(0) {
        }
        ["doc"]=>
        NULL
        ["parseddoc"]=>
        NULL
        ["docline"]=>
        NULL
      }
      [17]=>
      array(10) {
        ["type"]=>
        string(6) "method"
        ["name"]=>
        string(4) "test"
        ["startline"]=>
        int(69)
        ["endline"]=>
        int(71)
        ["parameters"]=>
        array(0) {
        }
        ["modifiers"]=>
        array(6) {
          [0]=>
          string(6) "public"
          [1]=>
          string(7) "private"
          [2]=>
          string(6) "static"
          [3]=>
          string(9) "protected"
          [4]=>
          string(8) "abstract"
          [5]=>
          string(5) "final"
        }
        ["info"]=>
        array(0) {
        }
        ["doc"]=>
        NULL
        ["parseddoc"]=>
        NULL
        ["docline"]=>
        NULL
      }
      [18]=>
      array(10) {
        ["type"]=>
        string(6) "method"
        ["name"]=>
        string(4) "test"
        ["startline"]=>
        int(71)
        ["endline"]=>
        int(73)
        ["parameters"]=>
        array(1) {
          [0]=>
          array(4) {
            ["typehint"]=>
            string(0) ""
            ["param"]=>
            string(2) "$a"
            ["isreference"]=>
            bool(false)
            ["default"]=>
            NULL
          }
        }
        ["modifiers"]=>
        array(1) {
          [0]=>
          string(6) "public"
        }
        ["info"]=>
        array(0) {
        }
        ["doc"]=>
        NULL
        ["parseddoc"]=>
        NULL
        ["docline"]=>
        NULL
      }
      [19]=>
      array(10) {
        ["type"]=>
        string(6) "method"
        ["name"]=>
        string(4) "test"
        ["startline"]=>
        int(73)
        ["endline"]=>
        int(74)
        ["parameters"]=>
        array(1) {
          [0]=>
          array(4) {
            ["typehint"]=>
            string(3) "Foo"
            ["param"]=>
            string(2) "$a"
            ["isreference"]=>
            bool(false)
            ["default"]=>
            NULL
          }
        }
        ["modifiers"]=>
        array(1) {
          [0]=>
          string(6) "public"
        }
        ["info"]=>
        array(0) {
        }
        ["doc"]=>
        NULL
        ["parseddoc"]=>
        NULL
        ["docline"]=>
        NULL
      }
      [20]=>
      array(10) {
        ["type"]=>
        string(6) "method"
        ["name"]=>
        string(4) "test"
        ["startline"]=>
        int(74)
        ["endline"]=>
        int(76)
        ["parameters"]=>
        array(1) {
          [0]=>
          array(4) {
            ["typehint"]=>
            string(5) "array"
            ["param"]=>
            string(2) "$a"
            ["isreference"]=>
            bool(false)
            ["default"]=>
            NULL
          }
        }
        ["modifiers"]=>
        array(1) {
          [0]=>
          string(6) "public"
        }
        ["info"]=>
        array(0) {
        }
        ["doc"]=>
        NULL
        ["parseddoc"]=>
        NULL
        ["docline"]=>
        NULL
      }
      [21]=>
      array(10) {
        ["type"]=>
        string(6) "method"
        ["name"]=>
        string(4) "test"
        ["startline"]=>
        int(76)
        ["endline"]=>
        int(77)
        ["parameters"]=>
        array(1) {
          [0]=>
          array(4) {
            ["typehint"]=>
            string(0) ""
            ["param"]=>
            string(2) "$a"
            ["isreference"]=>
            bool(true)
            ["default"]=>
            NULL
          }
        }
        ["modifiers"]=>
        array(1) {
          [0]=>
          string(6) "public"
        }
        ["info"]=>
        array(0) {
        }
        ["doc"]=>
        NULL
        ["parseddoc"]=>
        NULL
        ["docline"]=>
        NULL
      }
      [22]=>
      array(10) {
        ["type"]=>
        string(6) "method"
        ["name"]=>
        string(4) "test"
        ["startline"]=>
        int(77)
        ["endline"]=>
        int(78)
        ["parameters"]=>
        array(1) {
          [0]=>
          array(4) {
            ["typehint"]=>
            string(3) "Foo"
            ["param"]=>
            string(2) "$a"
            ["isreference"]=>
            bool(true)
            ["default"]=>
            NULL
          }
        }
        ["modifiers"]=>
        array(1) {
          [0]=>
          string(6) "public"
        }
        ["info"]=>
        array(0) {
        }
        ["doc"]=>
        NULL
        ["parseddoc"]=>
        NULL
        ["docline"]=>
        NULL
      }
      [23]=>
      array(10) {
        ["type"]=>
        string(6) "method"
        ["name"]=>
        string(4) "test"
        ["startline"]=>
        int(78)
        ["endline"]=>
        int(80)
        ["parameters"]=>
        array(1) {
          [0]=>
          array(4) {
            ["typehint"]=>
            string(5) "array"
            ["param"]=>
            string(2) "$a"
            ["isreference"]=>
            bool(true)
            ["default"]=>
            NULL
          }
        }
        ["modifiers"]=>
        array(1) {
          [0]=>
          string(6) "public"
        }
        ["info"]=>
        array(0) {
        }
        ["doc"]=>
        NULL
        ["parseddoc"]=>
        NULL
        ["docline"]=>
        NULL
      }
      [24]=>
      array(10) {
        ["type"]=>
        string(6) "method"
        ["name"]=>
        string(4) "test"
        ["startline"]=>
        int(80)
        ["endline"]=>
        int(81)
        ["parameters"]=>
        array(1) {
          [0]=>
          array(4) {
            ["typehint"]=>
            string(0) ""
            ["param"]=>
            string(2) "$a"
            ["isreference"]=>
            bool(true)
            ["default"]=>
            string(1) "1"
          }
        }
        ["modifiers"]=>
        array(1) {
          [0]=>
          string(6) "public"
        }
        ["info"]=>
        array(0) {
        }
        ["doc"]=>
        NULL
        ["parseddoc"]=>
        NULL
        ["docline"]=>
        NULL
      }
      [25]=>
      array(10) {
        ["type"]=>
        string(6) "method"
        ["name"]=>
        string(4) "test"
        ["startline"]=>
        int(81)
        ["endline"]=>
        int(82)
        ["parameters"]=>
        array(1) {
          [0]=>
          array(4) {
            ["typehint"]=>
            string(3) "Foo"
            ["param"]=>
            string(2) "$a"
            ["isreference"]=>
            bool(true)
            ["default"]=>
            string(4) "null"
          }
        }
        ["modifiers"]=>
        array(1) {
          [0]=>
          string(6) "public"
        }
        ["info"]=>
        array(0) {
        }
        ["doc"]=>
        NULL
        ["parseddoc"]=>
        NULL
        ["docline"]=>
        NULL
      }
      [26]=>
      array(10) {
        ["type"]=>
        string(6) "method"
        ["name"]=>
        string(4) "test"
        ["startline"]=>
        int(82)
        ["endline"]=>
        int(84)
        ["parameters"]=>
        array(1) {
          [0]=>
          array(4) {
            ["typehint"]=>
            string(5) "array"
            ["param"]=>
            string(2) "$a"
            ["isreference"]=>
            bool(true)
            ["default"]=>
            string(7) "array()"
          }
        }
        ["modifiers"]=>
        array(1) {
          [0]=>
          string(6) "public"
        }
        ["info"]=>
        array(0) {
        }
        ["doc"]=>
        NULL
        ["parseddoc"]=>
        NULL
        ["docline"]=>
        NULL
      }
      [27]=>
      array(10) {
        ["type"]=>
        string(6) "method"
        ["name"]=>
        string(4) "test"
        ["startline"]=>
        int(84)
        ["endline"]=>
        int(85)
        ["parameters"]=>
        array(1) {
          [0]=>
          array(4) {
            ["typehint"]=>
            string(0) ""
            ["param"]=>
            string(2) "$a"
            ["isreference"]=>
            bool(false)
            ["default"]=>
            string(1) "1"
          }
        }
        ["modifiers"]=>
        array(1) {
          [0]=>
          string(6) "public"
        }
        ["info"]=>
        array(0) {
        }
        ["doc"]=>
        NULL
        ["parseddoc"]=>
        NULL
        ["docline"]=>
        NULL
      }
      [28]=>
      array(10) {
        ["type"]=>
        string(6) "method"
        ["name"]=>
        string(4) "test"
        ["startline"]=>
        int(85)
        ["endline"]=>
        int(86)
        ["parameters"]=>
        array(1) {
          [0]=>
          array(4) {
            ["typehint"]=>
            string(3) "Foo"
            ["param"]=>
            string(2) "$a"
            ["isreference"]=>
            bool(false)
            ["default"]=>
            string(1) "2"
          }
        }
        ["modifiers"]=>
        array(1) {
          [0]=>
          string(6) "public"
        }
        ["info"]=>
        array(0) {
        }
        ["doc"]=>
        NULL
        ["parseddoc"]=>
        NULL
        ["docline"]=>
        NULL
      }
      [29]=>
      array(10) {
        ["type"]=>
        string(6) "method"
        ["name"]=>
        string(4) "test"
        ["startline"]=>
        int(86)
        ["endline"]=>
        int(88)
        ["parameters"]=>
        array(1) {
          [0]=>
          array(4) {
            ["typehint"]=>
            string(5) "array"
            ["param"]=>
            string(2) "$a"
            ["isreference"]=>
            bool(false)
            ["default"]=>
            string(4) "null"
          }
        }
        ["modifiers"]=>
        array(1) {
          [0]=>
          string(6) "public"
        }
        ["info"]=>
        array(0) {
        }
        ["doc"]=>
        NULL
        ["parseddoc"]=>
        NULL
        ["docline"]=>
        NULL
      }
      [30]=>
      array(10) {
        ["type"]=>
        string(6) "method"
        ["name"]=>
        string(4) "test"
        ["startline"]=>
        int(88)
        ["endline"]=>
        int(89)
        ["parameters"]=>
        array(2) {
          [0]=>
          array(4) {
            ["typehint"]=>
            string(0) ""
            ["param"]=>
            string(2) "$a"
            ["isreference"]=>
            bool(false)
            ["default"]=>
            NULL
          }
          [1]=>
          array(4) {
            ["typehint"]=>
            string(0) ""
            ["param"]=>
            string(2) "$b"
            ["isreference"]=>
            bool(false)
            ["default"]=>
            NULL
          }
        }
        ["modifiers"]=>
        array(1) {
          [0]=>
          string(6) "public"
        }
        ["info"]=>
        array(0) {
        }
        ["doc"]=>
        NULL
        ["parseddoc"]=>
        NULL
        ["docline"]=>
        NULL
      }
      [31]=>
      array(10) {
        ["type"]=>
        string(6) "method"
        ["name"]=>
        string(4) "test"
        ["startline"]=>
        int(89)
        ["endline"]=>
        int(90)
        ["parameters"]=>
        array(2) {
          [0]=>
          array(4) {
            ["typehint"]=>
            string(0) ""
            ["param"]=>
            string(2) "$a"
            ["isreference"]=>
            bool(false)
            ["default"]=>
            NULL
          }
          [1]=>
          array(4) {
            ["typehint"]=>
            string(3) "Foo"
            ["param"]=>
            string(2) "$b"
            ["isreference"]=>
            bool(false)
            ["default"]=>
            NULL
          }
        }
        ["modifiers"]=>
        array(1) {
          [0]=>
          string(6) "public"
        }
        ["info"]=>
        array(0) {
        }
        ["doc"]=>
        NULL
        ["parseddoc"]=>
        NULL
        ["docline"]=>
        NULL
      }
      [32]=>
      array(10) {
        ["type"]=>
        string(6) "method"
        ["name"]=>
        string(4) "test"
        ["startline"]=>
        int(90)
        ["endline"]=>
        int(92)
        ["parameters"]=>
        array(2) {
          [0]=>
          array(4) {
            ["typehint"]=>
            string(0) ""
            ["param"]=>
            string(2) "$a"
            ["isreference"]=>
            bool(false)
            ["default"]=>
            NULL
          }
          [1]=>
          array(4) {
            ["typehint"]=>
            string(5) "array"
            ["param"]=>
            string(2) "$b"
            ["isreference"]=>
            bool(false)
            ["default"]=>
            NULL
          }
        }
        ["modifiers"]=>
        array(1) {
          [0]=>
          string(6) "public"
        }
        ["info"]=>
        array(0) {
        }
        ["doc"]=>
        NULL
        ["parseddoc"]=>
        NULL
        ["docline"]=>
        NULL
      }
      [33]=>
      array(10) {
        ["type"]=>
        string(6) "method"
        ["name"]=>
        string(4) "test"
        ["startline"]=>
        int(92)
        ["endline"]=>
        int(93)
        ["parameters"]=>
        array(2) {
          [0]=>
          array(4) {
            ["typehint"]=>
            string(0) ""
            ["param"]=>
            string(2) "$a"
            ["isreference"]=>
            bool(false)
            ["default"]=>
            NULL
          }
          [1]=>
          array(4) {
            ["typehint"]=>
            string(0) ""
            ["param"]=>
            string(2) "$b"
            ["isreference"]=>
            bool(true)
            ["default"]=>
            NULL
          }
        }
        ["modifiers"]=>
        array(1) {
          [0]=>
          string(6) "public"
        }
        ["info"]=>
        array(0) {
        }
        ["doc"]=>
        NULL
        ["parseddoc"]=>
        NULL
        ["docline"]=>
        NULL
      }
      [34]=>
      array(10) {
        ["type"]=>
        string(6) "method"
        ["name"]=>
        string(4) "test"
        ["startline"]=>
        int(93)
        ["endline"]=>
        int(94)
        ["parameters"]=>
        array(2) {
          [0]=>
          array(4) {
            ["typehint"]=>
            string(0) ""
            ["param"]=>
            string(2) "$a"
            ["isreference"]=>
            bool(false)
            ["default"]=>
            NULL
          }
          [1]=>
          array(4) {
            ["typehint"]=>
            string(3) "Foo"
            ["param"]=>
            string(2) "$b"
            ["isreference"]=>
            bool(true)
            ["default"]=>
            NULL
          }
        }
        ["modifiers"]=>
        array(1) {
          [0]=>
          string(6) "public"
        }
        ["info"]=>
        array(0) {
        }
        ["doc"]=>
        NULL
        ["parseddoc"]=>
        NULL
        ["docline"]=>
        NULL
      }
      [35]=>
      array(10) {
        ["type"]=>
        string(6) "method"
        ["name"]=>
        string(4) "test"
        ["startline"]=>
        int(94)
        ["endline"]=>
        int(96)
        ["parameters"]=>
        array(2) {
          [0]=>
          array(4) {
            ["typehint"]=>
            string(0) ""
            ["param"]=>
            string(2) "$a"
            ["isreference"]=>
            bool(false)
            ["default"]=>
            NULL
          }
          [1]=>
          array(4) {
            ["typehint"]=>
            string(5) "array"
            ["param"]=>
            string(2) "$b"
            ["isreference"]=>
            bool(true)
            ["default"]=>
            NULL
          }
        }
        ["modifiers"]=>
        array(1) {
          [0]=>
          string(6) "public"
        }
        ["info"]=>
        array(0) {
        }
        ["doc"]=>
        NULL
        ["parseddoc"]=>
        NULL
        ["docline"]=>
        NULL
      }
      [36]=>
      array(10) {
        ["type"]=>
        string(6) "method"
        ["name"]=>
        string(4) "test"
        ["startline"]=>
        int(96)
        ["endline"]=>
        int(97)
        ["parameters"]=>
        array(2) {
          [0]=>
          array(4) {
            ["typehint"]=>
            string(0) ""
            ["param"]=>
            string(2) "$a"
            ["isreference"]=>
            bool(false)
            ["default"]=>
            NULL
          }
          [1]=>
          array(4) {
            ["typehint"]=>
            string(0) ""
            ["param"]=>
            string(2) "$b"
            ["isreference"]=>
            bool(true)
            ["default"]=>
            string(1) "1"
          }
        }
        ["modifiers"]=>
        array(1) {
          [0]=>
          string(6) "public"
        }
        ["info"]=>
        array(0) {
        }
        ["doc"]=>
        NULL
        ["parseddoc"]=>
        NULL
        ["docline"]=>
        NULL
      }
      [37]=>
      array(10) {
        ["type"]=>
        string(6) "method"
        ["name"]=>
        string(4) "test"
        ["startline"]=>
        int(97)
        ["endline"]=>
        int(98)
        ["parameters"]=>
        array(2) {
          [0]=>
          array(4) {
            ["typehint"]=>
            string(0) ""
            ["param"]=>
            string(2) "$a"
            ["isreference"]=>
            bool(false)
            ["default"]=>
            NULL
          }
          [1]=>
          array(4) {
            ["typehint"]=>
            string(3) "Foo"
            ["param"]=>
            string(2) "$b"
            ["isreference"]=>
            bool(true)
            ["default"]=>
            string(1) "2"
          }
        }
        ["modifiers"]=>
        array(1) {
          [0]=>
          string(6) "public"
        }
        ["info"]=>
        array(0) {
        }
        ["doc"]=>
        NULL
        ["parseddoc"]=>
        NULL
        ["docline"]=>
        NULL
      }
      [38]=>
      array(10) {
        ["type"]=>
        string(6) "method"
        ["name"]=>
        string(4) "test"
        ["startline"]=>
        int(98)
        ["endline"]=>
        int(100)
        ["parameters"]=>
        array(2) {
          [0]=>
          array(4) {
            ["typehint"]=>
            string(0) ""
            ["param"]=>
            string(2) "$a"
            ["isreference"]=>
            bool(false)
            ["default"]=>
            NULL
          }
          [1]=>
          array(4) {
            ["typehint"]=>
            string(5) "array"
            ["param"]=>
            string(2) "$b"
            ["isreference"]=>
            bool(true)
            ["default"]=>
            string(1) "3"
          }
        }
        ["modifiers"]=>
        array(1) {
          [0]=>
          string(6) "public"
        }
        ["info"]=>
        array(0) {
        }
        ["doc"]=>
        NULL
        ["parseddoc"]=>
        NULL
        ["docline"]=>
        NULL
      }
      [39]=>
      array(10) {
        ["type"]=>
        string(6) "method"
        ["name"]=>
        string(4) "test"
        ["startline"]=>
        int(100)
        ["endline"]=>
        int(101)
        ["parameters"]=>
        array(2) {
          [0]=>
          array(4) {
            ["typehint"]=>
            string(0) ""
            ["param"]=>
            string(2) "$a"
            ["isreference"]=>
            bool(false)
            ["default"]=>
            NULL
          }
          [1]=>
          array(4) {
            ["typehint"]=>
            string(0) ""
            ["param"]=>
            string(2) "$b"
            ["isreference"]=>
            bool(false)
            ["default"]=>
            string(1) "1"
          }
        }
        ["modifiers"]=>
        array(1) {
          [0]=>
          string(6) "public"
        }
        ["info"]=>
        array(0) {
        }
        ["doc"]=>
        NULL
        ["parseddoc"]=>
        NULL
        ["docline"]=>
        NULL
      }
      [40]=>
      array(10) {
        ["type"]=>
        string(6) "method"
        ["name"]=>
        string(4) "test"
        ["startline"]=>
        int(101)
        ["endline"]=>
        int(102)
        ["parameters"]=>
        array(2) {
          [0]=>
          array(4) {
            ["typehint"]=>
            string(0) ""
            ["param"]=>
            string(2) "$a"
            ["isreference"]=>
            bool(false)
            ["default"]=>
            NULL
          }
          [1]=>
          array(4) {
            ["typehint"]=>
            string(3) "Foo"
            ["param"]=>
            string(2) "$b"
            ["isreference"]=>
            bool(false)
            ["default"]=>
            string(1) "2"
          }
        }
        ["modifiers"]=>
        array(1) {
          [0]=>
          string(6) "public"
        }
        ["info"]=>
        array(0) {
        }
        ["doc"]=>
        NULL
        ["parseddoc"]=>
        NULL
        ["docline"]=>
        NULL
      }
      [41]=>
      array(10) {
        ["type"]=>
        string(6) "method"
        ["name"]=>
        string(4) "test"
        ["startline"]=>
        int(102)
        ["endline"]=>
        int(104)
        ["parameters"]=>
        array(2) {
          [0]=>
          array(4) {
            ["typehint"]=>
            string(0) ""
            ["param"]=>
            string(2) "$a"
            ["isreference"]=>
            bool(false)
            ["default"]=>
            NULL
          }
          [1]=>
          array(4) {
            ["typehint"]=>
            string(5) "array"
            ["param"]=>
            string(2) "$b"
            ["isreference"]=>
            bool(false)
            ["default"]=>
            string(1) "3"
          }
        }
        ["modifiers"]=>
        array(1) {
          [0]=>
          string(6) "public"
        }
        ["info"]=>
        array(0) {
        }
        ["doc"]=>
        NULL
        ["parseddoc"]=>
        NULL
        ["docline"]=>
        NULL
      }
    }
    ["doc"]=>
    string(0) ""
    ["parseddoc"]=>
    bool(false)
    ["docline"]=>
    int(-1)
  }
}
array(1) {
  ["foo"]=>
  array(7) {
    [0]=>
    array(11) {
      ["type"]=>
      string(5) "class"
      ["startline"]=>
      int(13)
      ["endline"]=>
      int(15)
      ["modifiers"]=>
      array(0) {
      }
      ["name"]=>
      string(3) "foo"
      ["extends"]=>
      array(0) {
      }
      ["implements"]=>
      array(0) {
      }
      ["info"]=>
      array(0) {
      }
      ["doc"]=>
      NULL
      ["parseddoc"]=>
      NULL
      ["docline"]=>
      NULL
    }
    [1]=>
    array(11) {
      ["type"]=>
      string(5) "class"
      ["startline"]=>
      int(15)
      ["endline"]=>
      int(17)
      ["modifiers"]=>
      array(1) {
        [0]=>
        string(8) "abstract"
      }
      ["name"]=>
      string(3) "foo"
      ["extends"]=>
      array(0) {
      }
      ["implements"]=>
      array(0) {
      }
      ["info"]=>
      array(0) {
      }
      ["doc"]=>
      string(0) ""
      ["parseddoc"]=>
      bool(false)
      ["docline"]=>
      int(-1)
    }
    [2]=>
    array(11) {
      ["type"]=>
      string(5) "class"
      ["startline"]=>
      int(17)
      ["endline"]=>
      int(20)
      ["modifiers"]=>
      array(1) {
        [0]=>
        string(5) "final"
      }
      ["name"]=>
      string(3) "foo"
      ["extends"]=>
      array(0) {
      }
      ["implements"]=>
      array(0) {
      }
      ["info"]=>
      array(0) {
      }
      ["doc"]=>
      string(0) ""
      ["parseddoc"]=>
      bool(false)
      ["docline"]=>
      int(-1)
    }
    [3]=>
    array(11) {
      ["type"]=>
      string(5) "class"
      ["startline"]=>
      int(20)
      ["endline"]=>
      int(25)
      ["modifiers"]=>
      array(0) {
      }
      ["name"]=>
      string(3) "foo"
      ["extends"]=>
      array(1) {
        [0]=>
        string(3) "bah"
      }
      ["implements"]=>
      array(0) {
      }
      ["info"]=>
      array(0) {
      }
      ["doc"]=>
      string(0) ""
      ["parseddoc"]=>
      bool(false)
      ["docline"]=>
      int(-1)
    }
    [4]=>
    array(11) {
      ["type"]=>
      string(5) "class"
      ["startline"]=>
      int(25)
      ["endline"]=>
      int(27)
      ["modifiers"]=>
      array(0) {
      }
      ["name"]=>
      string(3) "foo"
      ["extends"]=>
      array(0) {
      }
      ["implements"]=>
      array(1) {
        [0]=>
        string(3) "bor"
      }
      ["info"]=>
      array(0) {
      }
      ["doc"]=>
      string(0) ""
      ["parseddoc"]=>
      bool(false)
      ["docline"]=>
      int(-1)
    }
    [5]=>
    array(11) {
      ["type"]=>
      string(5) "class"
      ["startline"]=>
      int(27)
      ["endline"]=>
      int(30)
      ["modifiers"]=>
      array(0) {
      }
      ["name"]=>
      string(3) "foo"
      ["extends"]=>
      array(0) {
      }
      ["implements"]=>
      array(2) {
        [0]=>
        string(3) "bor"
        [1]=>
        string(3) "boo"
      }
      ["info"]=>
      array(0) {
      }
      ["doc"]=>
      string(0) ""
      ["parseddoc"]=>
      bool(false)
      ["docline"]=>
      int(-1)
    }
    [6]=>
    array(11) {
      ["type"]=>
      string(5) "class"
      ["startline"]=>
      int(30)
      ["endline"]=>
      int(105)
      ["modifiers"]=>
      array(0) {
      }
      ["name"]=>
      string(3) "foo"
      ["extends"]=>
      array(0) {
      }
      ["implements"]=>
      array(0) {
      }
      ["info"]=>
      array(42) {
        [0]=>
        array(8) {
          ["type"]=>
          string(3) "var"
          ["name"]=>
          string(2) "$a"
          ["line"]=>
          int(35)
          ["default"]=>
          NULL
          ["modifiers"]=>
          array(1) {
            [0]=>
            string(6) "public"
          }
          ["doc"]=>
          string(0) ""
          ["parseddoc"]=>
          bool(false)
          ["docline"]=>
          int(-1)
        }
        [1]=>
        array(8) {
          ["type"]=>
          string(3) "var"
          ["name"]=>
          string(2) "$a"
          ["line"]=>
          int(37)
          ["default"]=>
          string(1) "1"
          ["modifiers"]=>
          array(1) {
            [0]=>
            string(6) "public"
          }
          ["doc"]=>
          string(0) ""
          ["parseddoc"]=>
          bool(false)
          ["docline"]=>
          int(-1)
        }
        [2]=>
        array(8) {
          ["type"]=>
          string(3) "var"
          ["name"]=>
          string(2) "$a"
          ["line"]=>
          int(42)
          ["default"]=>
          NULL
          ["modifiers"]=>
          array(1) {
            [0]=>
            string(6) "public"
          }
          ["doc"]=>
          string(0) ""
          ["parseddoc"]=>
          bool(false)
          ["docline"]=>
          int(-1)
        }
        [3]=>
        array(8) {
          ["type"]=>
          string(3) "var"
          ["name"]=>
          string(2) "$a"
          ["line"]=>
          int(43)
          ["default"]=>
          NULL
          ["modifiers"]=>
          array(2) {
            [0]=>
            string(7) "private"
            [1]=>
            string(6) "public"
          }
          ["doc"]=>
          string(0) ""
          ["parseddoc"]=>
          bool(false)
          ["docline"]=>
          int(-1)
        }
        [4]=>
        array(8) {
          ["type"]=>
          string(3) "var"
          ["name"]=>
          string(2) "$a"
          ["line"]=>
          int(44)
          ["default"]=>
          NULL
          ["modifiers"]=>
          array(2) {
            [0]=>
            string(6) "static"
            [1]=>
            string(9) "protected"
          }
          ["doc"]=>
          string(0) ""
          ["parseddoc"]=>
          bool(false)
          ["docline"]=>
          int(-1)
        }
        [5]=>
        array(8) {
          ["type"]=>
          string(3) "var"
          ["name"]=>
          string(2) "$a"
          ["line"]=>
          int(45)
          ["default"]=>
          NULL
          ["modifiers"]=>
          array(2) {
            [0]=>
            string(6) "public"
            [1]=>
            string(5) "final"
          }
          ["doc"]=>
          string(0) ""
          ["parseddoc"]=>
          bool(false)
          ["docline"]=>
          int(-1)
        }
        [6]=>
        array(8) {
          ["type"]=>
          string(3) "var"
          ["name"]=>
          string(2) "$a"
          ["line"]=>
          int(46)
          ["default"]=>
          NULL
          ["modifiers"]=>
          array(2) {
            [0]=>
            string(6) "public"
            [1]=>
            string(8) "abstract"
          }
          ["doc"]=>
          string(0) ""
          ["parseddoc"]=>
          bool(false)
          ["docline"]=>
          int(-1)
        }
        [7]=>
        array(8) {
          ["type"]=>
          string(3) "var"
          ["name"]=>
          string(2) "$a"
          ["line"]=>
          int(48)
          ["default"]=>
          NULL
          ["modifiers"]=>
          array(2) {
            [0]=>
            string(6) "static"
            [1]=>
            string(7) "private"
          }
          ["doc"]=>
          string(0) ""
          ["parseddoc"]=>
          bool(false)
          ["docline"]=>
          int(-1)
        }
        [8]=>
        array(8) {
          ["type"]=>
          string(3) "var"
          ["name"]=>
          string(2) "$b"
          ["line"]=>
          int(48)
          ["default"]=>
          NULL
          ["modifiers"]=>
          array(2) {
            [0]=>
            string(6) "static"
            [1]=>
            string(7) "private"
          }
          ["doc"]=>
          string(0) ""
          ["parseddoc"]=>
          bool(false)
          ["docline"]=>
          int(-1)
        }
        [9]=>
        array(8) {
          ["type"]=>
          string(3) "var"
          ["name"]=>
          string(2) "$a"
          ["line"]=>
          int(50)
          ["default"]=>
          NULL
          ["modifiers"]=>
          array(2) {
            [0]=>
            string(8) "abstract"
            [1]=>
            string(6) "public"
          }
          ["doc"]=>
          string(0) ""
          ["parseddoc"]=>
          bool(false)
          ["docline"]=>
          int(-1)
        }
        [10]=>
        array(8) {
          ["type"]=>
          string(3) "var"
          ["name"]=>
          string(2) "$b"
          ["line"]=>
          int(50)
          ["default"]=>
          string(1) "1"
          ["modifiers"]=>
          array(2) {
            [0]=>
            string(8) "abstract"
            [1]=>
            string(6) "public"
          }
          ["doc"]=>
          string(0) ""
          ["parseddoc"]=>
          bool(false)
          ["docline"]=>
          int(-1)
        }
        [11]=>
        array(7) {
          ["type"]=>
          string(5) "const"
          ["name"]=>
          string(2) "hi"
          ["line"]=>
          int(54)
          ["value"]=>
          string(13) "array(1 => 2)"
          ["doc"]=>
          string(0) ""
          ["parseddoc"]=>
          bool(false)
          ["docline"]=>
          int(-1)
        }
        [12]=>
        array(7) {
          ["type"]=>
          string(5) "const"
          ["name"]=>
          string(3) "bye"
          ["line"]=>
          int(56)
          ["value"]=>
          string(1) "1"
          ["doc"]=>
          string(0) ""
          ["parseddoc"]=>
          bool(false)
          ["docline"]=>
          int(-1)
        }
        [13]=>
        array(7) {
          ["type"]=>
          string(5) "const"
          ["name"]=>
          string(10) "helloagain"
          ["line"]=>
          int(56)
          ["value"]=>
          string(7) "'matey'"
          ["doc"]=>
          string(0) ""
          ["parseddoc"]=>
          bool(false)
          ["docline"]=>
          int(-1)
        }
        [14]=>
        array(10) {
          ["type"]=>
          string(6) "method"
          ["name"]=>
          string(4) "test"
          ["startline"]=>
          int(63)
          ["endline"]=>
          int(65)
          ["parameters"]=>
          array(0) {
          }
          ["modifiers"]=>
          array(1) {
            [0]=>
            string(6) "public"
          }
          ["info"]=>
          array(0) {
          }
          ["doc"]=>
          NULL
          ["parseddoc"]=>
          NULL
          ["docline"]=>
          NULL
        }
        [15]=>
        array(10) {
          ["type"]=>
          string(6) "method"
          ["name"]=>
          string(4) "test"
          ["startline"]=>
          int(65)
          ["endline"]=>
          int(67)
          ["parameters"]=>
          array(0) {
          }
          ["modifiers"]=>
          array(1) {
            [0]=>
            string(6) "public"
          }
          ["info"]=>
          array(0) {
          }
          ["doc"]=>
          NULL
          ["parseddoc"]=>
          NULL
          ["docline"]=>
          NULL
        }
        [16]=>
        array(10) {
          ["type"]=>
          string(6) "method"
          ["name"]=>
          string(4) "test"
          ["startline"]=>
          int(67)
          ["endline"]=>
          int(69)
          ["parameters"]=>
          array(0) {
          }
          ["modifiers"]=>
          array(1) {
            [0]=>
            string(6) "public"
          }
          ["info"]=>
          array(0) {
          }
          ["doc"]=>
          NULL
          ["parseddoc"]=>
          NULL
          ["docline"]=>
          NULL
        }
        [17]=>
        array(10) {
          ["type"]=>
          string(6) "method"
          ["name"]=>
          string(4) "test"
          ["startline"]=>
          int(69)
          ["endline"]=>
          int(71)
          ["parameters"]=>
          array(0) {
          }
          ["modifiers"]=>
          array(6) {
            [0]=>
            string(6) "public"
            [1]=>
            string(7) "private"
            [2]=>
            string(6) "static"
            [3]=>
            string(9) "protected"
            [4]=>
            string(8) "abstract"
            [5]=>
            string(5) "final"
          }
          ["info"]=>
          array(0) {
          }
          ["doc"]=>
          NULL
          ["parseddoc"]=>
          NULL
          ["docline"]=>
          NULL
        }
        [18]=>
        array(10) {
          ["type"]=>
          string(6) "method"
          ["name"]=>
          string(4) "test"
          ["startline"]=>
          int(71)
          ["endline"]=>
          int(73)
          ["parameters"]=>
          array(1) {
            [0]=>
            array(4) {
              ["typehint"]=>
              string(0) ""
              ["param"]=>
              string(2) "$a"
              ["isreference"]=>
              bool(false)
              ["default"]=>
              NULL
            }
          }
          ["modifiers"]=>
          array(1) {
            [0]=>
            string(6) "public"
          }
          ["info"]=>
          array(0) {
          }
          ["doc"]=>
          NULL
          ["parseddoc"]=>
          NULL
          ["docline"]=>
          NULL
        }
        [19]=>
        array(10) {
          ["type"]=>
          string(6) "method"
          ["name"]=>
          string(4) "test"
          ["startline"]=>
          int(73)
          ["endline"]=>
          int(74)
          ["parameters"]=>
          array(1) {
            [0]=>
            array(4) {
              ["typehint"]=>
              string(3) "Foo"
              ["param"]=>
              string(2) "$a"
              ["isreference"]=>
              bool(false)
              ["default"]=>
              NULL
            }
          }
          ["modifiers"]=>
          array(1) {
            [0]=>
            string(6) "public"
          }
          ["info"]=>
          array(0) {
          }
          ["doc"]=>
          NULL
          ["parseddoc"]=>
          NULL
          ["docline"]=>
          NULL
        }
        [20]=>
        array(10) {
          ["type"]=>
          string(6) "method"
          ["name"]=>
          string(4) "test"
          ["startline"]=>
          int(74)
          ["endline"]=>
          int(76)
          ["parameters"]=>
          array(1) {
            [0]=>
            array(4) {
              ["typehint"]=>
              string(5) "array"
              ["param"]=>
              string(2) "$a"
              ["isreference"]=>
              bool(false)
              ["default"]=>
              NULL
            }
          }
          ["modifiers"]=>
          array(1) {
            [0]=>
            string(6) "public"
          }
          ["info"]=>
          array(0) {
          }
          ["doc"]=>
          NULL
          ["parseddoc"]=>
          NULL
          ["docline"]=>
          NULL
        }
        [21]=>
        array(10) {
          ["type"]=>
          string(6) "method"
          ["name"]=>
          string(4) "test"
          ["startline"]=>
          int(76)
          ["endline"]=>
          int(77)
          ["parameters"]=>
          array(1) {
            [0]=>
            array(4) {
              ["typehint"]=>
              string(0) ""
              ["param"]=>
              string(2) "$a"
              ["isreference"]=>
              bool(true)
              ["default"]=>
              NULL
            }
          }
          ["modifiers"]=>
          array(1) {
            [0]=>
            string(6) "public"
          }
          ["info"]=>
          array(0) {
          }
          ["doc"]=>
          NULL
          ["parseddoc"]=>
          NULL
          ["docline"]=>
          NULL
        }
        [22]=>
        array(10) {
          ["type"]=>
          string(6) "method"
          ["name"]=>
          string(4) "test"
          ["startline"]=>
          int(77)
          ["endline"]=>
          int(78)
          ["parameters"]=>
          array(1) {
            [0]=>
            array(4) {
              ["typehint"]=>
              string(3) "Foo"
              ["param"]=>
              string(2) "$a"
              ["isreference"]=>
              bool(true)
              ["default"]=>
              NULL
            }
          }
          ["modifiers"]=>
          array(1) {
            [0]=>
            string(6) "public"
          }
          ["info"]=>
          array(0) {
          }
          ["doc"]=>
          NULL
          ["parseddoc"]=>
          NULL
          ["docline"]=>
          NULL
        }
        [23]=>
        array(10) {
          ["type"]=>
          string(6) "method"
          ["name"]=>
          string(4) "test"
          ["startline"]=>
          int(78)
          ["endline"]=>
          int(80)
          ["parameters"]=>
          array(1) {
            [0]=>
            array(4) {
              ["typehint"]=>
              string(5) "array"
              ["param"]=>
              string(2) "$a"
              ["isreference"]=>
              bool(true)
              ["default"]=>
              NULL
            }
          }
          ["modifiers"]=>
          array(1) {
            [0]=>
            string(6) "public"
          }
          ["info"]=>
          array(0) {
          }
          ["doc"]=>
          NULL
          ["parseddoc"]=>
          NULL
          ["docline"]=>
          NULL
        }
        [24]=>
        array(10) {
          ["type"]=>
          string(6) "method"
          ["name"]=>
          string(4) "test"
          ["startline"]=>
          int(80)
          ["endline"]=>
          int(81)
          ["parameters"]=>
          array(1) {
            [0]=>
            array(4) {
              ["typehint"]=>
              string(0) ""
              ["param"]=>
              string(2) "$a"
              ["isreference"]=>
              bool(true)
              ["default"]=>
              string(1) "1"
            }
          }
          ["modifiers"]=>
          array(1) {
            [0]=>
            string(6) "public"
          }
          ["info"]=>
          array(0) {
          }
          ["doc"]=>
          NULL
          ["parseddoc"]=>
          NULL
          ["docline"]=>
          NULL
        }
        [25]=>
        array(10) {
          ["type"]=>
          string(6) "method"
          ["name"]=>
          string(4) "test"
          ["startline"]=>
          int(81)
          ["endline"]=>
          int(82)
          ["parameters"]=>
          array(1) {
            [0]=>
            array(4) {
              ["typehint"]=>
              string(3) "Foo"
              ["param"]=>
              string(2) "$a"
              ["isreference"]=>
              bool(true)
              ["default"]=>
              string(4) "null"
            }
          }
          ["modifiers"]=>
          array(1) {
            [0]=>
            string(6) "public"
          }
          ["info"]=>
          array(0) {
          }
          ["doc"]=>
          NULL
          ["parseddoc"]=>
          NULL
          ["docline"]=>
          NULL
        }
        [26]=>
        array(10) {
          ["type"]=>
          string(6) "method"
          ["name"]=>
          string(4) "test"
          ["startline"]=>
          int(82)
          ["endline"]=>
          int(84)
          ["parameters"]=>
          array(1) {
            [0]=>
            array(4) {
              ["typehint"]=>
              string(5) "array"
              ["param"]=>
              string(2) "$a"
              ["isreference"]=>
              bool(true)
              ["default"]=>
              string(7) "array()"
            }
          }
          ["modifiers"]=>
          array(1) {
            [0]=>
            string(6) "public"
          }
          ["info"]=>
          array(0) {
          }
          ["doc"]=>
          NULL
          ["parseddoc"]=>
          NULL
          ["docline"]=>
          NULL
        }
        [27]=>
        array(10) {
          ["type"]=>
          string(6) "method"
          ["name"]=>
          string(4) "test"
          ["startline"]=>
          int(84)
          ["endline"]=>
          int(85)
          ["parameters"]=>
          array(1) {
            [0]=>
            array(4) {
              ["typehint"]=>
              string(0) ""
              ["param"]=>
              string(2) "$a"
              ["isreference"]=>
              bool(false)
              ["default"]=>
              string(1) "1"
            }
          }
          ["modifiers"]=>
          array(1) {
            [0]=>
            string(6) "public"
          }
          ["info"]=>
          array(0) {
          }
          ["doc"]=>
          NULL
          ["parseddoc"]=>
          NULL
          ["docline"]=>
          NULL
        }
        [28]=>
        array(10) {
          ["type"]=>
          string(6) "method"
          ["name"]=>
          string(4) "test"
          ["startline"]=>
          int(85)
          ["endline"]=>
          int(86)
          ["parameters"]=>
          array(1) {
            [0]=>
            array(4) {
              ["typehint"]=>
              string(3) "Foo"
              ["param"]=>
              string(2) "$a"
              ["isreference"]=>
              bool(false)
              ["default"]=>
              string(1) "2"
            }
          }
          ["modifiers"]=>
          array(1) {
            [0]=>
            string(6) "public"
          }
          ["info"]=>
          array(0) {
          }
          ["doc"]=>
          NULL
          ["parseddoc"]=>
          NULL
          ["docline"]=>
          NULL
        }
        [29]=>
        array(10) {
          ["type"]=>
          string(6) "method"
          ["name"]=>
          string(4) "test"
          ["startline"]=>
          int(86)
          ["endline"]=>
          int(88)
          ["parameters"]=>
          array(1) {
            [0]=>
            array(4) {
              ["typehint"]=>
              string(5) "array"
              ["param"]=>
              string(2) "$a"
              ["isreference"]=>
              bool(false)
              ["default"]=>
              string(4) "null"
            }
          }
          ["modifiers"]=>
          array(1) {
            [0]=>
            string(6) "public"
          }
          ["info"]=>
          array(0) {
          }
          ["doc"]=>
          NULL
          ["parseddoc"]=>
          NULL
          ["docline"]=>
          NULL
        }
        [30]=>
        array(10) {
          ["type"]=>
          string(6) "method"
          ["name"]=>
          string(4) "test"
          ["startline"]=>
          int(88)
          ["endline"]=>
          int(89)
          ["parameters"]=>
          array(2) {
            [0]=>
            array(4) {
              ["typehint"]=>
              string(0) ""
              ["param"]=>
              string(2) "$a"
              ["isreference"]=>
              bool(false)
              ["default"]=>
              NULL
            }
            [1]=>
            array(4) {
              ["typehint"]=>
              string(0) ""
              ["param"]=>
              string(2) "$b"
              ["isreference"]=>
              bool(false)
              ["default"]=>
              NULL
            }
          }
          ["modifiers"]=>
          array(1) {
            [0]=>
            string(6) "public"
          }
          ["info"]=>
          array(0) {
          }
          ["doc"]=>
          NULL
          ["parseddoc"]=>
          NULL
          ["docline"]=>
          NULL
        }
        [31]=>
        array(10) {
          ["type"]=>
          string(6) "method"
          ["name"]=>
          string(4) "test"
          ["startline"]=>
          int(89)
          ["endline"]=>
          int(90)
          ["parameters"]=>
          array(2) {
            [0]=>
            array(4) {
              ["typehint"]=>
              string(0) ""
              ["param"]=>
              string(2) "$a"
              ["isreference"]=>
              bool(false)
              ["default"]=>
              NULL
            }
            [1]=>
            array(4) {
              ["typehint"]=>
              string(3) "Foo"
              ["param"]=>
              string(2) "$b"
              ["isreference"]=>
              bool(false)
              ["default"]=>
              NULL
            }
          }
          ["modifiers"]=>
          array(1) {
            [0]=>
            string(6) "public"
          }
          ["info"]=>
          array(0) {
          }
          ["doc"]=>
          NULL
          ["parseddoc"]=>
          NULL
          ["docline"]=>
          NULL
        }
        [32]=>
        array(10) {
          ["type"]=>
          string(6) "method"
          ["name"]=>
          string(4) "test"
          ["startline"]=>
          int(90)
          ["endline"]=>
          int(92)
          ["parameters"]=>
          array(2) {
            [0]=>
            array(4) {
              ["typehint"]=>
              string(0) ""
              ["param"]=>
              string(2) "$a"
              ["isreference"]=>
              bool(false)
              ["default"]=>
              NULL
            }
            [1]=>
            array(4) {
              ["typehint"]=>
              string(5) "array"
              ["param"]=>
              string(2) "$b"
              ["isreference"]=>
              bool(false)
              ["default"]=>
              NULL
            }
          }
          ["modifiers"]=>
          array(1) {
            [0]=>
            string(6) "public"
          }
          ["info"]=>
          array(0) {
          }
          ["doc"]=>
          NULL
          ["parseddoc"]=>
          NULL
          ["docline"]=>
          NULL
        }
        [33]=>
        array(10) {
          ["type"]=>
          string(6) "method"
          ["name"]=>
          string(4) "test"
          ["startline"]=>
          int(92)
          ["endline"]=>
          int(93)
          ["parameters"]=>
          array(2) {
            [0]=>
            array(4) {
              ["typehint"]=>
              string(0) ""
              ["param"]=>
              string(2) "$a"
              ["isreference"]=>
              bool(false)
              ["default"]=>
              NULL
            }
            [1]=>
            array(4) {
              ["typehint"]=>
              string(0) ""
              ["param"]=>
              string(2) "$b"
              ["isreference"]=>
              bool(true)
              ["default"]=>
              NULL
            }
          }
          ["modifiers"]=>
          array(1) {
            [0]=>
            string(6) "public"
          }
          ["info"]=>
          array(0) {
          }
          ["doc"]=>
          NULL
          ["parseddoc"]=>
          NULL
          ["docline"]=>
          NULL
        }
        [34]=>
        array(10) {
          ["type"]=>
          string(6) "method"
          ["name"]=>
          string(4) "test"
          ["startline"]=>
          int(93)
          ["endline"]=>
          int(94)
          ["parameters"]=>
          array(2) {
            [0]=>
            array(4) {
              ["typehint"]=>
              string(0) ""
              ["param"]=>
              string(2) "$a"
              ["isreference"]=>
              bool(false)
              ["default"]=>
              NULL
            }
            [1]=>
            array(4) {
              ["typehint"]=>
              string(3) "Foo"
              ["param"]=>
              string(2) "$b"
              ["isreference"]=>
              bool(true)
              ["default"]=>
              NULL
            }
          }
          ["modifiers"]=>
          array(1) {
            [0]=>
            string(6) "public"
          }
          ["info"]=>
          array(0) {
          }
          ["doc"]=>
          NULL
          ["parseddoc"]=>
          NULL
          ["docline"]=>
          NULL
        }
        [35]=>
        array(10) {
          ["type"]=>
          string(6) "method"
          ["name"]=>
          string(4) "test"
          ["startline"]=>
          int(94)
          ["endline"]=>
          int(96)
          ["parameters"]=>
          array(2) {
            [0]=>
            array(4) {
              ["typehint"]=>
              string(0) ""
              ["param"]=>
              string(2) "$a"
              ["isreference"]=>
              bool(false)
              ["default"]=>
              NULL
            }
            [1]=>
            array(4) {
              ["typehint"]=>
              string(5) "array"
              ["param"]=>
              string(2) "$b"
              ["isreference"]=>
              bool(true)
              ["default"]=>
              NULL
            }
          }
          ["modifiers"]=>
          array(1) {
            [0]=>
            string(6) "public"
          }
          ["info"]=>
          array(0) {
          }
          ["doc"]=>
          NULL
          ["parseddoc"]=>
          NULL
          ["docline"]=>
          NULL
        }
        [36]=>
        array(10) {
          ["type"]=>
          string(6) "method"
          ["name"]=>
          string(4) "test"
          ["startline"]=>
          int(96)
          ["endline"]=>
          int(97)
          ["parameters"]=>
          array(2) {
            [0]=>
            array(4) {
              ["typehint"]=>
              string(0) ""
              ["param"]=>
              string(2) "$a"
              ["isreference"]=>
              bool(false)
              ["default"]=>
              NULL
            }
            [1]=>
            array(4) {
              ["typehint"]=>
              string(0) ""
              ["param"]=>
              string(2) "$b"
              ["isreference"]=>
              bool(true)
              ["default"]=>
              string(1) "1"
            }
          }
          ["modifiers"]=>
          array(1) {
            [0]=>
            string(6) "public"
          }
          ["info"]=>
          array(0) {
          }
          ["doc"]=>
          NULL
          ["parseddoc"]=>
          NULL
          ["docline"]=>
          NULL
        }
        [37]=>
        array(10) {
          ["type"]=>
          string(6) "method"
          ["name"]=>
          string(4) "test"
          ["startline"]=>
          int(97)
          ["endline"]=>
          int(98)
          ["parameters"]=>
          array(2) {
            [0]=>
            array(4) {
              ["typehint"]=>
              string(0) ""
              ["param"]=>
              string(2) "$a"
              ["isreference"]=>
              bool(false)
              ["default"]=>
              NULL
            }
            [1]=>
            array(4) {
              ["typehint"]=>
              string(3) "Foo"
              ["param"]=>
              string(2) "$b"
              ["isreference"]=>
              bool(true)
              ["default"]=>
              string(1) "2"
            }
          }
          ["modifiers"]=>
          array(1) {
            [0]=>
            string(6) "public"
          }
          ["info"]=>
          array(0) {
          }
          ["doc"]=>
          NULL
          ["parseddoc"]=>
          NULL
          ["docline"]=>
          NULL
        }
        [38]=>
        array(10) {
          ["type"]=>
          string(6) "method"
          ["name"]=>
          string(4) "test"
          ["startline"]=>
          int(98)
          ["endline"]=>
          int(100)
          ["parameters"]=>
          array(2) {
            [0]=>
            array(4) {
              ["typehint"]=>
              string(0) ""
              ["param"]=>
              string(2) "$a"
              ["isreference"]=>
              bool(false)
              ["default"]=>
              NULL
            }
            [1]=>
            array(4) {
              ["typehint"]=>
              string(5) "array"
              ["param"]=>
              string(2) "$b"
              ["isreference"]=>
              bool(true)
              ["default"]=>
              string(1) "3"
            }
          }
          ["modifiers"]=>
          array(1) {
            [0]=>
            string(6) "public"
          }
          ["info"]=>
          array(0) {
          }
          ["doc"]=>
          NULL
          ["parseddoc"]=>
          NULL
          ["docline"]=>
          NULL
        }
        [39]=>
        array(10) {
          ["type"]=>
          string(6) "method"
          ["name"]=>
          string(4) "test"
          ["startline"]=>
          int(100)
          ["endline"]=>
          int(101)
          ["parameters"]=>
          array(2) {
            [0]=>
            array(4) {
              ["typehint"]=>
              string(0) ""
              ["param"]=>
              string(2) "$a"
              ["isreference"]=>
              bool(false)
              ["default"]=>
              NULL
            }
            [1]=>
            array(4) {
              ["typehint"]=>
              string(0) ""
              ["param"]=>
              string(2) "$b"
              ["isreference"]=>
              bool(false)
              ["default"]=>
              string(1) "1"
            }
          }
          ["modifiers"]=>
          array(1) {
            [0]=>
            string(6) "public"
          }
          ["info"]=>
          array(0) {
          }
          ["doc"]=>
          NULL
          ["parseddoc"]=>
          NULL
          ["docline"]=>
          NULL
        }
        [40]=>
        array(10) {
          ["type"]=>
          string(6) "method"
          ["name"]=>
          string(4) "test"
          ["startline"]=>
          int(101)
          ["endline"]=>
          int(102)
          ["parameters"]=>
          array(2) {
            [0]=>
            array(4) {
              ["typehint"]=>
              string(0) ""
              ["param"]=>
              string(2) "$a"
              ["isreference"]=>
              bool(false)
              ["default"]=>
              NULL
            }
            [1]=>
            array(4) {
              ["typehint"]=>
              string(3) "Foo"
              ["param"]=>
              string(2) "$b"
              ["isreference"]=>
              bool(false)
              ["default"]=>
              string(1) "2"
            }
          }
          ["modifiers"]=>
          array(1) {
            [0]=>
            string(6) "public"
          }
          ["info"]=>
          array(0) {
          }
          ["doc"]=>
          NULL
          ["parseddoc"]=>
          NULL
          ["docline"]=>
          NULL
        }
        [41]=>
        array(10) {
          ["type"]=>
          string(6) "method"
          ["name"]=>
          string(4) "test"
          ["startline"]=>
          int(102)
          ["endline"]=>
          int(104)
          ["parameters"]=>
          array(2) {
            [0]=>
            array(4) {
              ["typehint"]=>
              string(0) ""
              ["param"]=>
              string(2) "$a"
              ["isreference"]=>
              bool(false)
              ["default"]=>
              NULL
            }
            [1]=>
            array(4) {
              ["typehint"]=>
              string(5) "array"
              ["param"]=>
              string(2) "$b"
              ["isreference"]=>
              bool(false)
              ["default"]=>
              string(1) "3"
            }
          }
          ["modifiers"]=>
          array(1) {
            [0]=>
            string(6) "public"
          }
          ["info"]=>
          array(0) {
          }
          ["doc"]=>
          NULL
          ["parseddoc"]=>
          NULL
          ["docline"]=>
          NULL
        }
      }
      ["doc"]=>
      string(0) ""
      ["parseddoc"]=>
      bool(false)
      ["docline"]=>
      int(-1)
    }
  }
}
array(0) {
}
array(0) {
}
array(0) {
}
array(0) {
}
===DONE===