<script type="text/javascript">
    
    testObj = {
        name: null,
        getName: function() {
            return this.name;
        }
    };
    
    $(document).ready(function(){
        
        bob = extend(testObj);
        bob.name = 'Bob';

        frank = extend(testObj);
        frank.name = 'Frank';
          
        test("engine.js extend() test 1 Bob", function() {
          equal( bob.getName(), "Bob", "We expected Bob");
        });

        test("engine.js extend() test 2 - Frank", function() {
          equal( frank.getName(), "Frank", "We expected Frank");
        });

    });
</script>
  
<h1 id="qunit-header">QUnit UI Testing</h1>

<h2 id="qunit-banner"></h2>

<div id="qunit-testrunner-toolbar"></div>

<h2 id="qunit-userAgent"></h2>

<ol id="qunit-tests"></ol>

<div id="qunit-fixture">test markup, will be hidden</div>