<refentry id="{@id}">
 <refnamediv>
  <refname>Using the PHP_Parser_MsgServer class</refname>
  <refpurpose>inter-class double-blind communication and true abstraction</refpurpose>
 </refnamediv>
 <refsynopsisdiv>
  <refsynopsisdivinfo>
   <author>
    Gregory Beaver
    <authorblurb>Tag Documentation written by {@link mailto:cellog@users.sourceforge.net cellog@users.sourceforge.net}</authorblurb>
   </author>
   <copyright>Copyright 2004, Gregory Beaver</copyright>
   <releaseinfo>PHP_Parser 0.3+</releaseinfo>
  </refsynopsisdivinfo>
  <cmdsynopsis>
    <command>require_once 'PHP/Parser/MsgServer.php';</command>
   </cmdsynopsis>
 </refsynopsisdiv>
 <refsect1 id="{@id description}">
  <title>Description</title>
  <para>
   Most well-designed packages or applications rely upon communication
   between several inter-dependent segments of code.  In PHP, these
   segments are best represented by classes.  In a traditional application,
   a class defines public methods, and to access these methods, one simply
   instantiates a class as follows:
  </para>
  <para>
   <programlisting role="php">
    <![CDATA[
class MainClass {
    var $_used;
    function MainClass()
    {
        $this->_used = new Used();
    }
}

class Used {
}
    ]]>
   </programlisting>
  </para>
  <para>
   This is perfectly acceptable.  What, however, if a few months/years down the
   line, a user downloads your package and decides that the Used class simply 
   doesn't do what he or she needs it to do?  There is only one good choice:
   subclass MainClass.
  </para>
  <para>
   This is complicated by programs with user interfaces like phpDocumentor
   and PEAR.  What if a user wishes to use a different Packager class for pear
   package?  This user has no choice but to directly modify the source for
   pearcmd.php, and that is always a bad option when it comes time to upgrade.
   What if the user forgets about these customizations and over-writes them
   before realizing it?
  </para>
  <para>
   This class solves the problems created by complex interdependent classes.
   In the example above, the user would simply write a plugin for the pear
   command, and register that plugin as a new handler for the functionality
   needed.  pearcmd.php would not need to know that anything has changed, as
   the interface between the classes is well-defined.  Only the implementation
   has changed.
  </para>
  <para>
   In phpDocumentor, the Parser class needs to communicate with the storage and
   sorting classes like IntermediateParser and its cousins
   Classes/ProceduralPages.  The HighlightParser class needs to communicate
   with the current Converter class in order to do its work properly.  Often, a
   class will need to query another class, and then work with the response.
   These kind of relationships make it very difficult to upgrade design, should
   anything change.
  </para>
  <para>
   The MsgServer class allows the details of communication to be abstracted into
   a simple format.  Now, the class <classname>MainClass</classname> from our sample above
   doesn't care whether it is dealing with a <classname>Used</classname>,
   <classname>Abused</classname> or some other unwritten future class - or even a
   combination of more than one class!
  </para>
  <para>
   The MsgServer class relies upon registration of "Listeners," classes that
   contain a method named "handleMessage()" that take a single parameter, a
   {@link MsgServer_Msg} class.  Listeners in turn register with
   {@link catchMessage()} to respond to message types, defined by any string
   name or integer.  Finally, any portion of code can send a message out to
   registered listeners with the {@link sendMessage()} method, and most
   significant, can receive information using the
   {@link sendMessageGetAnswer()} method.
  </para>
  <para>
   Now our example looks like:
  </para>
  <para>
   <programlisting role="php">
    <![CDATA[
class Used {
    function handleMessage($msg)
    {
        switch ($msg->getType()) {
            case 'phone' :
                $msg->setData('555-1212');
            break;
            case 'email' :
                $msg->setData('example@example.com');
            break;
        }
        return $msg;
    }
}

class Abused {
    function handleMessage($msg)
    {
        switch ($msg->getType()) {
            case 'phone' :
                $msg->setData('(303) 555-1212');
            break;
            case 'email' :
                $msg->setData('example@example.com');
            break;
        }
        return $msg;
    }
}

class MainClass {
    function test()
    {
        // retrieve message server, or make new server 
        $server = &PHP_Parser_MsgServer::singleton();
        $msg = new PHP_Parser_MsgServer_Msg;
        $msg->setType('phone');
        $ret = $server->sendMessageGetAnswer($msg);
        if (!is_array($ret)) {
            echo 'No registered listeners catch the phone message';
            return;
        }
        foreach ($ret as $id => $phone_number) {
            echo 'Class Ided as "'.$id.'" returned Phone : ' 
                 . $phone_number->getData()."\n";
        }
    }
}

$first = new User;
$third = new Abuser;

// prints 'No registered listeners catch the phone message'
MainClass::test();

$server = &PHP_Parser_MsgServer::singleton();
// register a class as a listener
$server->registerListener('first', $first);
// tell the server to catch the 'phone' message
$server->catchMessage('phone', 'first');

// prints 'Class Ided as "first" returned Phone : 555-1212'
MainClass::test();

// register another class as a listener
$server->registerListener('third', $third);
// tell the server to catch the 'phone' message
$server->catchMessage('phone', 'third');

// prints:
// Class Ided as "first" returned Phone : 555-1212
// Class Ided as "third" returned Phone : (303) 555-1212
MainClass::test();
    ]]>
   </programlisting>
  </para>
  <para>
   So, to summarize, the MsgServer class solves the communication issues that
   surround upgrading a package
   <itemizedlist>
    <listitem>
     <simpara>
      anonymous interaction through a well-defined API keeps the need for
      redundant modifications to a minimum
     </simpara
    </listitem>
    <listitem>
     <simpara>
      classes with new functionality can be swapped in and out without any
      modification to the original code in a program
     </simpara
    </listitem>
    <listitem>
     <simpara>
      more listeners can be added to a message type with no modification,
      allowing unlimited scalability
      completely new code can be swapped in.  For instance, a new CMS could
      be installed and work right off the bat with existing code written for
      the old CMS
     </simpara>
    <listitem>
   </itemizedlist>
  </para>
 </refsect1>
</refentry>