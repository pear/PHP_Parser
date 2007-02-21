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
?>
===DONE===
--EXPECT--
array(7) {
  [0]=>
  array(6) {
    ["type"]=>
    string(5) "class"
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
  }
  [1]=>
  array(6) {
    ["type"]=>
    string(5) "class"
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
  }
  [2]=>
  array(6) {
    ["type"]=>
    string(5) "class"
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
  }
  [3]=>
  array(6) {
    ["type"]=>
    string(5) "class"
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
  }
  [4]=>
  array(6) {
    ["type"]=>
    string(5) "class"
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
  }
  [5]=>
  array(6) {
    ["type"]=>
    string(5) "class"
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
  }
  [6]=>
  array(6) {
    ["type"]=>
    string(5) "class"
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
      array(4) {
        ["type"]=>
        string(3) "var"
        ["name"]=>
        string(2) "$a"
        ["default"]=>
        NULL
        ["modifiers"]=>
        array(1) {
          [0]=>
          string(6) "public"
        }
      }
      [1]=>
      array(4) {
        ["type"]=>
        string(3) "var"
        ["name"]=>
        string(2) "$a"
        ["default"]=>
        string(1) "1"
        ["modifiers"]=>
        array(1) {
          [0]=>
          string(6) "public"
        }
      }
      [2]=>
      array(4) {
        ["type"]=>
        string(3) "var"
        ["name"]=>
        string(2) "$a"
        ["default"]=>
        NULL
        ["modifiers"]=>
        array(1) {
          [0]=>
          string(6) "public"
        }
      }
      [3]=>
      array(4) {
        ["type"]=>
        string(3) "var"
        ["name"]=>
        string(2) "$a"
        ["default"]=>
        NULL
        ["modifiers"]=>
        array(2) {
          [0]=>
          string(7) "private"
          [1]=>
          string(6) "public"
        }
      }
      [4]=>
      array(4) {
        ["type"]=>
        string(3) "var"
        ["name"]=>
        string(2) "$a"
        ["default"]=>
        NULL
        ["modifiers"]=>
        array(2) {
          [0]=>
          string(6) "static"
          [1]=>
          string(9) "protected"
        }
      }
      [5]=>
      array(4) {
        ["type"]=>
        string(3) "var"
        ["name"]=>
        string(2) "$a"
        ["default"]=>
        NULL
        ["modifiers"]=>
        array(2) {
          [0]=>
          string(6) "public"
          [1]=>
          string(5) "final"
        }
      }
      [6]=>
      array(4) {
        ["type"]=>
        string(3) "var"
        ["name"]=>
        string(2) "$a"
        ["default"]=>
        NULL
        ["modifiers"]=>
        array(2) {
          [0]=>
          string(6) "public"
          [1]=>
          string(8) "abstract"
        }
      }
      [7]=>
      array(4) {
        ["type"]=>
        string(3) "var"
        ["name"]=>
        string(2) "$a"
        ["default"]=>
        NULL
        ["modifiers"]=>
        array(2) {
          [0]=>
          string(6) "static"
          [1]=>
          string(7) "private"
        }
      }
      [8]=>
      array(4) {
        ["type"]=>
        string(3) "var"
        ["name"]=>
        string(2) "$b"
        ["default"]=>
        NULL
        ["modifiers"]=>
        array(2) {
          [0]=>
          string(6) "static"
          [1]=>
          string(7) "private"
        }
      }
      [9]=>
      array(4) {
        ["type"]=>
        string(3) "var"
        ["name"]=>
        string(2) "$a"
        ["default"]=>
        NULL
        ["modifiers"]=>
        array(2) {
          [0]=>
          string(8) "abstract"
          [1]=>
          string(6) "public"
        }
      }
      [10]=>
      array(4) {
        ["type"]=>
        string(3) "var"
        ["name"]=>
        string(2) "$b"
        ["default"]=>
        string(1) "1"
        ["modifiers"]=>
        array(2) {
          [0]=>
          string(8) "abstract"
          [1]=>
          string(6) "public"
        }
      }
      [11]=>
      array(3) {
        ["type"]=>
        string(5) "const"
        ["name"]=>
        string(2) "hi"
        ["value"]=>
        string(13) "array(1 => 2)"
      }
      [12]=>
      array(3) {
        ["type"]=>
        string(5) "const"
        ["name"]=>
        string(3) "bye"
        ["value"]=>
        string(1) "1"
      }
      [13]=>
      array(3) {
        ["type"]=>
        string(5) "const"
        ["name"]=>
        string(10) "helloagain"
        ["value"]=>
        string(7) "'matey'"
      }
      [14]=>
      array(5) {
        ["type"]=>
        string(6) "method"
        ["name"]=>
        string(4) "test"
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
      }
      [15]=>
      array(5) {
        ["type"]=>
        string(6) "method"
        ["name"]=>
        string(4) "test"
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
      }
      [16]=>
      array(5) {
        ["type"]=>
        string(6) "method"
        ["name"]=>
        string(4) "test"
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
      }
      [17]=>
      array(5) {
        ["type"]=>
        string(6) "method"
        ["name"]=>
        string(4) "test"
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
      }
      [18]=>
      array(5) {
        ["type"]=>
        string(6) "method"
        ["name"]=>
        string(4) "test"
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
      }
      [19]=>
      array(5) {
        ["type"]=>
        string(6) "method"
        ["name"]=>
        string(4) "test"
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
      }
      [20]=>
      array(5) {
        ["type"]=>
        string(6) "method"
        ["name"]=>
        string(4) "test"
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
      }
      [21]=>
      array(5) {
        ["type"]=>
        string(6) "method"
        ["name"]=>
        string(4) "test"
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
      }
      [22]=>
      array(5) {
        ["type"]=>
        string(6) "method"
        ["name"]=>
        string(4) "test"
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
      }
      [23]=>
      array(5) {
        ["type"]=>
        string(6) "method"
        ["name"]=>
        string(4) "test"
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
      }
      [24]=>
      array(5) {
        ["type"]=>
        string(6) "method"
        ["name"]=>
        string(4) "test"
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
      }
      [25]=>
      array(5) {
        ["type"]=>
        string(6) "method"
        ["name"]=>
        string(4) "test"
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
      }
      [26]=>
      array(5) {
        ["type"]=>
        string(6) "method"
        ["name"]=>
        string(4) "test"
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
      }
      [27]=>
      array(5) {
        ["type"]=>
        string(6) "method"
        ["name"]=>
        string(4) "test"
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
      }
      [28]=>
      array(5) {
        ["type"]=>
        string(6) "method"
        ["name"]=>
        string(4) "test"
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
      }
      [29]=>
      array(5) {
        ["type"]=>
        string(6) "method"
        ["name"]=>
        string(4) "test"
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
      }
      [30]=>
      array(5) {
        ["type"]=>
        string(6) "method"
        ["name"]=>
        string(4) "test"
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
      }
      [31]=>
      array(5) {
        ["type"]=>
        string(6) "method"
        ["name"]=>
        string(4) "test"
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
      }
      [32]=>
      array(5) {
        ["type"]=>
        string(6) "method"
        ["name"]=>
        string(4) "test"
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
      }
      [33]=>
      array(5) {
        ["type"]=>
        string(6) "method"
        ["name"]=>
        string(4) "test"
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
      }
      [34]=>
      array(5) {
        ["type"]=>
        string(6) "method"
        ["name"]=>
        string(4) "test"
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
      }
      [35]=>
      array(5) {
        ["type"]=>
        string(6) "method"
        ["name"]=>
        string(4) "test"
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
      }
      [36]=>
      array(5) {
        ["type"]=>
        string(6) "method"
        ["name"]=>
        string(4) "test"
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
      }
      [37]=>
      array(5) {
        ["type"]=>
        string(6) "method"
        ["name"]=>
        string(4) "test"
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
      }
      [38]=>
      array(5) {
        ["type"]=>
        string(6) "method"
        ["name"]=>
        string(4) "test"
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
      }
      [39]=>
      array(5) {
        ["type"]=>
        string(6) "method"
        ["name"]=>
        string(4) "test"
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
      }
      [40]=>
      array(5) {
        ["type"]=>
        string(6) "method"
        ["name"]=>
        string(4) "test"
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
      }
      [41]=>
      array(5) {
        ["type"]=>
        string(6) "method"
        ["name"]=>
        string(4) "test"
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
      }
    }
  }
}
===DONE===