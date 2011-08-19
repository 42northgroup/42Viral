<script type="text/javascript">
    $(document).ready(function(){

        test("a basic test example", function() {
          ok( true, "this test is fine" );
          var value = "hello";
          equal( value, "hello", "We expect value to be hello" );
        });

        module("Module A");

        test("first test within module", function() {
          ok( true, "all pass" );
        });

        test("second test within module", function() {
          ok( true, "all pass" );
        });

        module("Module B");

        test("some other test", function() {
          expect(2);
          equal( true, false, "failing test" );
          equal( true, true, "passing test" );
        });

    });
</script>
  
<h1 id="qunit-header">QUnit example</h1>
<h2 id="qunit-banner"></h2>
<div id="qunit-testrunner-toolbar"></div>
<h2 id="qunit-userAgent"></h2>
<ol id="qunit-tests"></ol>
<div id="qunit-fixture">test markup, will be hidden</div>