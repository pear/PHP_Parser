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
var_dump($b->classes);
var_dump($b->interfaces);
var_dump($b->functions);
var_dump($b->includes);
var_dump($b->globals);
?>
===DONE===
--EXPECT--
array(26) {
  [0]=>
  array(7) {
    ["type"]=>
    string(8) "function"
    ["startline"]=>
    int(6)
    ["endline"]=>
    int(7)
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
  array(7) {
    ["type"]=>
    string(8) "function"
    ["startline"]=>
    int(7)
    ["endline"]=>
    int(10)
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
  array(7) {
    ["type"]=>
    string(8) "function"
    ["startline"]=>
    int(10)
    ["endline"]=>
    int(12)
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
  array(7) {
    ["type"]=>
    string(8) "function"
    ["startline"]=>
    int(12)
    ["endline"]=>
    int(13)
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
  array(7) {
    ["type"]=>
    string(8) "function"
    ["startline"]=>
    int(13)
    ["endline"]=>
    int(15)
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
  array(7) {
    ["type"]=>
    string(8) "function"
    ["startline"]=>
    int(15)
    ["endline"]=>
    int(16)
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
  array(7) {
    ["type"]=>
    string(8) "function"
    ["startline"]=>
    int(16)
    ["endline"]=>
    int(17)
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
  array(7) {
    ["type"]=>
    string(8) "function"
    ["startline"]=>
    int(17)
    ["endline"]=>
    int(19)
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
  array(7) {
    ["type"]=>
    string(8) "function"
    ["startline"]=>
    int(19)
    ["endline"]=>
    int(20)
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
  array(7) {
    ["type"]=>
    string(8) "function"
    ["startline"]=>
    int(20)
    ["endline"]=>
    int(21)
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
  array(7) {
    ["type"]=>
    string(8) "function"
    ["startline"]=>
    int(21)
    ["endline"]=>
    int(23)
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
  array(7) {
    ["type"]=>
    string(8) "function"
    ["startline"]=>
    int(23)
    ["endline"]=>
    int(24)
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
  array(7) {
    ["type"]=>
    string(8) "function"
    ["startline"]=>
    int(24)
    ["endline"]=>
    int(25)
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
  array(7) {
    ["type"]=>
    string(8) "function"
    ["startline"]=>
    int(25)
    ["endline"]=>
    int(27)
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
  array(7) {
    ["type"]=>
    string(8) "function"
    ["startline"]=>
    int(27)
    ["endline"]=>
    int(28)
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
  array(7) {
    ["type"]=>
    string(8) "function"
    ["startline"]=>
    int(28)
    ["endline"]=>
    int(29)
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
  array(7) {
    ["type"]=>
    string(8) "function"
    ["startline"]=>
    int(29)
    ["endline"]=>
    int(31)
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
  array(7) {
    ["type"]=>
    string(8) "function"
    ["startline"]=>
    int(31)
    ["endline"]=>
    int(32)
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
  array(7) {
    ["type"]=>
    string(8) "function"
    ["startline"]=>
    int(32)
    ["endline"]=>
    int(33)
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
  array(7) {
    ["type"]=>
    string(8) "function"
    ["startline"]=>
    int(33)
    ["endline"]=>
    int(35)
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
  array(7) {
    ["type"]=>
    string(8) "function"
    ["startline"]=>
    int(35)
    ["endline"]=>
    int(36)
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
  array(7) {
    ["type"]=>
    string(8) "function"
    ["startline"]=>
    int(36)
    ["endline"]=>
    int(37)
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
  array(7) {
    ["type"]=>
    string(8) "function"
    ["startline"]=>
    int(37)
    ["endline"]=>
    int(39)
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
  array(7) {
    ["type"]=>
    string(8) "function"
    ["startline"]=>
    int(39)
    ["endline"]=>
    int(40)
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
  array(7) {
    ["type"]=>
    string(8) "function"
    ["startline"]=>
    int(40)
    ["endline"]=>
    int(41)
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
  array(7) {
    ["type"]=>
    string(8) "function"
    ["startline"]=>
    int(41)
    ["endline"]=>
    int(43)
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
array(0) {
}
array(0) {
}
array(1) {
  ["test"]=>
  array(26) {
    [0]=>
    array(7) {
      ["type"]=>
      string(8) "function"
      ["startline"]=>
      int(6)
      ["endline"]=>
      int(7)
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
    array(7) {
      ["type"]=>
      string(8) "function"
      ["startline"]=>
      int(7)
      ["endline"]=>
      int(10)
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
    array(7) {
      ["type"]=>
      string(8) "function"
      ["startline"]=>
      int(10)
      ["endline"]=>
      int(12)
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
    array(7) {
      ["type"]=>
      string(8) "function"
      ["startline"]=>
      int(12)
      ["endline"]=>
      int(13)
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
    array(7) {
      ["type"]=>
      string(8) "function"
      ["startline"]=>
      int(13)
      ["endline"]=>
      int(15)
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
    array(7) {
      ["type"]=>
      string(8) "function"
      ["startline"]=>
      int(15)
      ["endline"]=>
      int(16)
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
    array(7) {
      ["type"]=>
      string(8) "function"
      ["startline"]=>
      int(16)
      ["endline"]=>
      int(17)
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
    array(7) {
      ["type"]=>
      string(8) "function"
      ["startline"]=>
      int(17)
      ["endline"]=>
      int(19)
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
    array(7) {
      ["type"]=>
      string(8) "function"
      ["startline"]=>
      int(19)
      ["endline"]=>
      int(20)
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
    array(7) {
      ["type"]=>
      string(8) "function"
      ["startline"]=>
      int(20)
      ["endline"]=>
      int(21)
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
    array(7) {
      ["type"]=>
      string(8) "function"
      ["startline"]=>
      int(21)
      ["endline"]=>
      int(23)
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
    array(7) {
      ["type"]=>
      string(8) "function"
      ["startline"]=>
      int(23)
      ["endline"]=>
      int(24)
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
    array(7) {
      ["type"]=>
      string(8) "function"
      ["startline"]=>
      int(24)
      ["endline"]=>
      int(25)
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
    array(7) {
      ["type"]=>
      string(8) "function"
      ["startline"]=>
      int(25)
      ["endline"]=>
      int(27)
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
    array(7) {
      ["type"]=>
      string(8) "function"
      ["startline"]=>
      int(27)
      ["endline"]=>
      int(28)
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
    array(7) {
      ["type"]=>
      string(8) "function"
      ["startline"]=>
      int(28)
      ["endline"]=>
      int(29)
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
    array(7) {
      ["type"]=>
      string(8) "function"
      ["startline"]=>
      int(29)
      ["endline"]=>
      int(31)
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
    array(7) {
      ["type"]=>
      string(8) "function"
      ["startline"]=>
      int(31)
      ["endline"]=>
      int(32)
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
    array(7) {
      ["type"]=>
      string(8) "function"
      ["startline"]=>
      int(32)
      ["endline"]=>
      int(33)
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
    array(7) {
      ["type"]=>
      string(8) "function"
      ["startline"]=>
      int(33)
      ["endline"]=>
      int(35)
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
    array(7) {
      ["type"]=>
      string(8) "function"
      ["startline"]=>
      int(35)
      ["endline"]=>
      int(36)
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
    array(7) {
      ["type"]=>
      string(8) "function"
      ["startline"]=>
      int(36)
      ["endline"]=>
      int(37)
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
    array(7) {
      ["type"]=>
      string(8) "function"
      ["startline"]=>
      int(37)
      ["endline"]=>
      int(39)
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
    array(7) {
      ["type"]=>
      string(8) "function"
      ["startline"]=>
      int(39)
      ["endline"]=>
      int(40)
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
    array(7) {
      ["type"]=>
      string(8) "function"
      ["startline"]=>
      int(40)
      ["endline"]=>
      int(41)
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
    array(7) {
      ["type"]=>
      string(8) "function"
      ["startline"]=>
      int(41)
      ["endline"]=>
      int(43)
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
}
array(0) {
}
array(0) {
}
===DONE===