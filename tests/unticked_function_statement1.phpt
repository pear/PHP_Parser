--TEST--
PHP_Parser: test unticked_function_statement 1
--FILE--
<?php
require_once 'PHP/Parser/Core.php';
require_once 'PHP/Parser/Tokenizer.php';
$a = new PHP_Parser_Tokenizer(file_get_contents(dirname(__FILE__) . '/files/unticked_function_statement1.inc'));
$b = new PHP_Parser_Core($a);
while ($a->advance()) {
    $b->doParse($a->token, $a->getValue(), $a);
}
$b->doParse(0, 0);
var_dump($b->data);
?>
===DONE===
--EXPECT--
array(26) {
  [0]=>
  array(5) {
    ["type"]=>
    string(8) "function"
    ["returnsref"]=>
    bool(false)
    ["name"]=>
    string(4) "test"
    ["parameters"]=>
    array(0) {
    }
    ["info"]=>
    array(0) {
    }
  }
  [1]=>
  array(5) {
    ["type"]=>
    string(8) "function"
    ["returnsref"]=>
    bool(true)
    ["name"]=>
    string(4) "test"
    ["parameters"]=>
    array(0) {
    }
    ["info"]=>
    array(0) {
    }
  }
  [2]=>
  array(5) {
    ["type"]=>
    string(8) "function"
    ["returnsref"]=>
    bool(false)
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
    ["info"]=>
    array(0) {
    }
  }
  [3]=>
  array(5) {
    ["type"]=>
    string(8) "function"
    ["returnsref"]=>
    bool(false)
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
    ["info"]=>
    array(0) {
    }
  }
  [4]=>
  array(5) {
    ["type"]=>
    string(8) "function"
    ["returnsref"]=>
    bool(false)
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
    ["info"]=>
    array(0) {
    }
  }
  [5]=>
  array(5) {
    ["type"]=>
    string(8) "function"
    ["returnsref"]=>
    bool(false)
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
    ["info"]=>
    array(0) {
    }
  }
  [6]=>
  array(5) {
    ["type"]=>
    string(8) "function"
    ["returnsref"]=>
    bool(false)
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
    ["info"]=>
    array(0) {
    }
  }
  [7]=>
  array(5) {
    ["type"]=>
    string(8) "function"
    ["returnsref"]=>
    bool(false)
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
    ["info"]=>
    array(0) {
    }
  }
  [8]=>
  array(5) {
    ["type"]=>
    string(8) "function"
    ["returnsref"]=>
    bool(false)
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
    ["info"]=>
    array(0) {
    }
  }
  [9]=>
  array(5) {
    ["type"]=>
    string(8) "function"
    ["returnsref"]=>
    bool(false)
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
    ["info"]=>
    array(0) {
    }
  }
  [10]=>
  array(5) {
    ["type"]=>
    string(8) "function"
    ["returnsref"]=>
    bool(false)
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
    ["info"]=>
    array(0) {
    }
  }
  [11]=>
  array(5) {
    ["type"]=>
    string(8) "function"
    ["returnsref"]=>
    bool(false)
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
    ["info"]=>
    array(0) {
    }
  }
  [12]=>
  array(5) {
    ["type"]=>
    string(8) "function"
    ["returnsref"]=>
    bool(false)
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
    ["info"]=>
    array(0) {
    }
  }
  [13]=>
  array(5) {
    ["type"]=>
    string(8) "function"
    ["returnsref"]=>
    bool(false)
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
    ["info"]=>
    array(0) {
    }
  }
  [14]=>
  array(5) {
    ["type"]=>
    string(8) "function"
    ["returnsref"]=>
    bool(false)
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
    ["info"]=>
    array(0) {
    }
  }
  [15]=>
  array(5) {
    ["type"]=>
    string(8) "function"
    ["returnsref"]=>
    bool(false)
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
    ["info"]=>
    array(0) {
    }
  }
  [16]=>
  array(5) {
    ["type"]=>
    string(8) "function"
    ["returnsref"]=>
    bool(false)
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
    ["info"]=>
    array(0) {
    }
  }
  [17]=>
  array(5) {
    ["type"]=>
    string(8) "function"
    ["returnsref"]=>
    bool(false)
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
    ["info"]=>
    array(0) {
    }
  }
  [18]=>
  array(5) {
    ["type"]=>
    string(8) "function"
    ["returnsref"]=>
    bool(false)
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
    ["info"]=>
    array(0) {
    }
  }
  [19]=>
  array(5) {
    ["type"]=>
    string(8) "function"
    ["returnsref"]=>
    bool(false)
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
    ["info"]=>
    array(0) {
    }
  }
  [20]=>
  array(5) {
    ["type"]=>
    string(8) "function"
    ["returnsref"]=>
    bool(false)
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
    ["info"]=>
    array(0) {
    }
  }
  [21]=>
  array(5) {
    ["type"]=>
    string(8) "function"
    ["returnsref"]=>
    bool(false)
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
    ["info"]=>
    array(0) {
    }
  }
  [22]=>
  array(5) {
    ["type"]=>
    string(8) "function"
    ["returnsref"]=>
    bool(false)
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
    ["info"]=>
    array(0) {
    }
  }
  [23]=>
  array(5) {
    ["type"]=>
    string(8) "function"
    ["returnsref"]=>
    bool(false)
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
    ["info"]=>
    array(0) {
    }
  }
  [24]=>
  array(5) {
    ["type"]=>
    string(8) "function"
    ["returnsref"]=>
    bool(false)
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
    ["info"]=>
    array(0) {
    }
  }
  [25]=>
  array(5) {
    ["type"]=>
    string(8) "function"
    ["returnsref"]=>
    bool(false)
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
    ["info"]=>
    array(0) {
    }
  }
}
===DONE===