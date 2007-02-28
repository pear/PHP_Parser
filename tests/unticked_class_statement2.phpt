--TEST--
PHP_Parser: test unticked_class_statement 2
--FILE--
<?php
require_once 'PHP/Parser/Core.php';
require_once 'PHP/Parser/Tokenizer.php';
$a = new PHP_Parser_Tokenizer(file_get_contents(dirname(__FILE__) . '/files/unticked_class_statement2.inc'));
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
array(1) {
  [0]=>
  array(8) {
    ["type"]=>
    string(5) "class"
    ["startline"]=>
    int(2)
    ["endline"]=>
    int(227)
    ["modifiers"]=>
    array(0) {
    }
    ["name"]=>
    string(4) "test"
    ["extends"]=>
    array(0) {
    }
    ["implements"]=>
    array(0) {
    }
    ["info"]=>
    array(2) {
      [0]=>
      array(7) {
        ["type"]=>
        string(6) "method"
        ["name"]=>
        string(4) "test"
        ["startline"]=>
        int(4)
        ["endline"]=>
        int(8)
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
      [1]=>
      array(7) {
        ["type"]=>
        string(6) "method"
        ["name"]=>
        string(4) "test"
        ["startline"]=>
        int(8)
        ["endline"]=>
        int(226)
        ["parameters"]=>
        array(0) {
        }
        ["modifiers"]=>
        array(1) {
          [0]=>
          string(6) "public"
        }
        ["info"]=>
        array(23) {
          [0]=>
          array(1) {
            ["global"]=>
            string(2) "$a"
          }
          [1]=>
          array(1) {
            ["global"]=>
            string(2) "$a"
          }
          [2]=>
          array(2) {
            ["static"]=>
            string(2) "$a"
            ["default"]=>
            NULL
          }
          [3]=>
          array(2) {
            ["static"]=>
            string(2) "$a"
            ["default"]=>
            string(1) "1"
          }
          [4]=>
          array(2) {
            ["static"]=>
            string(2) "$a"
            ["default"]=>
            NULL
          }
          [5]=>
          array(2) {
            ["static"]=>
            string(2) "$b"
            ["default"]=>
            string(1) "1"
          }
          [6]=>
          array(2) {
            ["static"]=>
            string(2) "$a"
            ["default"]=>
            NULL
          }
          [7]=>
          array(2) {
            ["static"]=>
            string(2) "$b"
            ["default"]=>
            NULL
          }
          [8]=>
          array(1) {
            ["uses"]=>
            string(4) "'hi'"
          }
          [9]=>
          array(1) {
            ["uses"]=>
            string(6) "('hi')"
          }
          [10]=>
          array(2) {
            ["declare"]=>
            string(2) "hi"
            ["default"]=>
            string(1) "1"
          }
          [11]=>
          array(2) {
            ["declare"]=>
            string(2) "hi"
            ["default"]=>
            string(1) "1"
          }
          [12]=>
          array(2) {
            ["declare"]=>
            string(3) "hit"
            ["default"]=>
            string(1) "2"
          }
          [13]=>
          array(2) {
            ["declare"]=>
            string(3) "bye"
            ["default"]=>
            string(1) "3"
          }
          [14]=>
          array(2) {
            ["declare"]=>
            string(3) "hit"
            ["default"]=>
            string(1) "2"
          }
          [15]=>
          array(2) {
            ["declare"]=>
            string(3) "bye"
            ["default"]=>
            string(1) "3"
          }
          [16]=>
          array(1) {
            ["catches"]=>
            string(4) "Blah"
          }
          [17]=>
          array(1) {
            ["catches"]=>
            string(4) "Blah"
          }
          [18]=>
          array(1) {
            ["catches"]=>
            string(3) "Foo"
          }
          [19]=>
          array(1) {
            ["throws"]=>
            string(9) "Classname"
          }
          [20]=>
          array(7) {
            ["type"]=>
            string(8) "function"
            ["startline"]=>
            int(222)
            ["endline"]=>
            int(223)
            ["returnsref"]=>
            bool(false)
            ["name"]=>
            string(6) "inside"
            ["parameters"]=>
            array(0) {
            }
            ["info"]=>
            array(0) {
            }
          }
          [21]=>
          array(8) {
            ["type"]=>
            string(5) "class"
            ["startline"]=>
            int(223)
            ["endline"]=>
            int(224)
            ["modifiers"]=>
            array(0) {
            }
            ["name"]=>
            string(6) "inside"
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
          [22]=>
          array(6) {
            ["type"]=>
            string(9) "interface"
            ["startline"]=>
            int(224)
            ["endline"]=>
            int(225)
            ["name"]=>
            string(6) "inside"
            ["extends"]=>
            array(0) {
            }
            ["info"]=>
            array(0) {
            }
          }
        }
      }
    }
  }
}
array(2) {
  ["inside"]=>
  array(1) {
    [0]=>
    array(8) {
      ["type"]=>
      string(5) "class"
      ["startline"]=>
      int(223)
      ["endline"]=>
      int(224)
      ["modifiers"]=>
      array(0) {
      }
      ["name"]=>
      string(6) "inside"
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
  }
  ["test"]=>
  array(1) {
    [0]=>
    array(8) {
      ["type"]=>
      string(5) "class"
      ["startline"]=>
      int(2)
      ["endline"]=>
      int(227)
      ["modifiers"]=>
      array(0) {
      }
      ["name"]=>
      string(4) "test"
      ["extends"]=>
      array(0) {
      }
      ["implements"]=>
      array(0) {
      }
      ["info"]=>
      array(2) {
        [0]=>
        array(7) {
          ["type"]=>
          string(6) "method"
          ["name"]=>
          string(4) "test"
          ["startline"]=>
          int(4)
          ["endline"]=>
          int(8)
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
        [1]=>
        array(7) {
          ["type"]=>
          string(6) "method"
          ["name"]=>
          string(4) "test"
          ["startline"]=>
          int(8)
          ["endline"]=>
          int(226)
          ["parameters"]=>
          array(0) {
          }
          ["modifiers"]=>
          array(1) {
            [0]=>
            string(6) "public"
          }
          ["info"]=>
          array(23) {
            [0]=>
            array(1) {
              ["global"]=>
              string(2) "$a"
            }
            [1]=>
            array(1) {
              ["global"]=>
              string(2) "$a"
            }
            [2]=>
            array(2) {
              ["static"]=>
              string(2) "$a"
              ["default"]=>
              NULL
            }
            [3]=>
            array(2) {
              ["static"]=>
              string(2) "$a"
              ["default"]=>
              string(1) "1"
            }
            [4]=>
            array(2) {
              ["static"]=>
              string(2) "$a"
              ["default"]=>
              NULL
            }
            [5]=>
            array(2) {
              ["static"]=>
              string(2) "$b"
              ["default"]=>
              string(1) "1"
            }
            [6]=>
            array(2) {
              ["static"]=>
              string(2) "$a"
              ["default"]=>
              NULL
            }
            [7]=>
            array(2) {
              ["static"]=>
              string(2) "$b"
              ["default"]=>
              NULL
            }
            [8]=>
            array(1) {
              ["uses"]=>
              string(4) "'hi'"
            }
            [9]=>
            array(1) {
              ["uses"]=>
              string(6) "('hi')"
            }
            [10]=>
            array(2) {
              ["declare"]=>
              string(2) "hi"
              ["default"]=>
              string(1) "1"
            }
            [11]=>
            array(2) {
              ["declare"]=>
              string(2) "hi"
              ["default"]=>
              string(1) "1"
            }
            [12]=>
            array(2) {
              ["declare"]=>
              string(3) "hit"
              ["default"]=>
              string(1) "2"
            }
            [13]=>
            array(2) {
              ["declare"]=>
              string(3) "bye"
              ["default"]=>
              string(1) "3"
            }
            [14]=>
            array(2) {
              ["declare"]=>
              string(3) "hit"
              ["default"]=>
              string(1) "2"
            }
            [15]=>
            array(2) {
              ["declare"]=>
              string(3) "bye"
              ["default"]=>
              string(1) "3"
            }
            [16]=>
            array(1) {
              ["catches"]=>
              string(4) "Blah"
            }
            [17]=>
            array(1) {
              ["catches"]=>
              string(4) "Blah"
            }
            [18]=>
            array(1) {
              ["catches"]=>
              string(3) "Foo"
            }
            [19]=>
            array(1) {
              ["throws"]=>
              string(9) "Classname"
            }
            [20]=>
            array(7) {
              ["type"]=>
              string(8) "function"
              ["startline"]=>
              int(222)
              ["endline"]=>
              int(223)
              ["returnsref"]=>
              bool(false)
              ["name"]=>
              string(6) "inside"
              ["parameters"]=>
              array(0) {
              }
              ["info"]=>
              array(0) {
              }
            }
            [21]=>
            array(8) {
              ["type"]=>
              string(5) "class"
              ["startline"]=>
              int(223)
              ["endline"]=>
              int(224)
              ["modifiers"]=>
              array(0) {
              }
              ["name"]=>
              string(6) "inside"
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
            [22]=>
            array(6) {
              ["type"]=>
              string(9) "interface"
              ["startline"]=>
              int(224)
              ["endline"]=>
              int(225)
              ["name"]=>
              string(6) "inside"
              ["extends"]=>
              array(0) {
              }
              ["info"]=>
              array(0) {
              }
            }
          }
        }
      }
    }
  }
}
array(1) {
  ["inside"]=>
  array(1) {
    [0]=>
    array(6) {
      ["type"]=>
      string(9) "interface"
      ["startline"]=>
      int(224)
      ["endline"]=>
      int(225)
      ["name"]=>
      string(6) "inside"
      ["extends"]=>
      array(0) {
      }
      ["info"]=>
      array(0) {
      }
    }
  }
}
array(1) {
  ["inside"]=>
  array(1) {
    [0]=>
    array(7) {
      ["type"]=>
      string(8) "function"
      ["startline"]=>
      int(222)
      ["endline"]=>
      int(223)
      ["returnsref"]=>
      bool(false)
      ["name"]=>
      string(6) "inside"
      ["parameters"]=>
      array(0) {
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