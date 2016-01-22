<?php
/**
 * String helper tests
 ** 
 * @package         	Cineman/Workbench
 * @author       		Mario Döring
 *
 * @group Workbench
 * @group Workbench_Str
 */

namespace Workbench\Tests;

use Workbench\Str;

class StrTest extends \PHPUnit_Framework_TestCase
{
	/**
	 * test charset getter
	 */
	public function testCharset() 
	{
		// test some returns
		$this->assertEquals( Str::charset( 'password' ) , Str::SECURE );
		$this->assertEquals( Str::charset( 'secure' ) , Str::SECURE );
		$this->assertEquals( Str::charset( 'pass' ) , Str::SECURE );
		
		$this->assertEquals( Str::charset( 'hex' ) , Str::HEX );
		
		$this->assertEquals( Str::charset( 'bin' ) , Str::BIN );
		
		$this->assertEquals( Str::charset( 'pass' ) , Str::SECURE );
		
		$this->assertEquals( Str::charset( 'alpha_low' ) , Str::ALPHA_LOW );
		$this->assertEquals( Str::charset( 'lowercase' ) , Str::ALPHA_LOW );
		
		// custom
		$this->assertEquals( Str::charset( 'customchaset' ) , 'customchaset' );
	}
	
	/**
	 * test random string
	 */
	public function testRandom() 
	{
		$this->assertEquals( strlen( Str::random( 5 ) ), 5 );
		$this->assertEquals( strlen( Str::random() ), 25 );
		
		// test random charset
		$random_str = Str::random( 10, 'lowercase' );
		
		for( $i=0;$i<strlen( $random_str );$i++ )
		{
			$this->assertTrue( ( strpos( Str::ALPHA_LOW, $random_str[$i] ) ) !== false );
		}
	}
	
	/**
	 * test string captureing
	 */
	public function testCapture() 
	{
		// callback
		$this->assertEquals( Str::capture( function(){
			echo "Test";
		}), 'Test' );
		
		// normal
		$this->assertEquals(  Str::capture( 'Test' ), 'Test' );
		
		// params
		$this->assertEquals( Str::capture( function( $q ) {
			echo $q;
		}, 'Test2' ), 'Test2' );
		
		// params array
		$this->assertEquals( Str::capture( function( $q ) {
			echo $q;
		}, array( 'Test2' ) ), 'Test2' );
	}
	
	/**
	 * test entities
	 */
	public function testHtmlentities() 
	{
		// normal 
		$this->assertEquals( Str::htmlentities( '<test>' ), '&lt;test&gt;' );
		
		// array
		$this->assertEquals( Str::htmlentities( array( '<test>', '<test2>' ) ), array( '&lt;test&gt;', '&lt;test2&gt;' ) );
				
		// multi dimensional array
		$this->assertEquals( Str::htmlentities( array( 
			'<test>', 
			'test'	=> array(
				'<test3>'
			),
		), true ), array( 
			'&lt;test&gt;',
			'test'	=> array(
				'&lt;test3&gt;'
			),
		));
	}
	
	/**
	 * test suffix
	 */
	public function testSuffix() 
	{
		$this->assertEquals( Str::suffix( 'test.php', '.' ), 'php' );
		$this->assertEquals( Str::suffix( 'Main::Sub', '::' ), 'Sub' );
		$this->assertEquals( Str::suffix( 'ControllerMain', 'Controller' ), 'Main' );
	}
	
	/**
	 * test prefix
	 */
	public function testPrefix() 
	{
		$this->assertEquals( Str::prefix( 'test.php', '.' ), 'test' );
		$this->assertEquals( Str::prefix( 'Main::Sub', '::' ), 'Main' );
		$this->assertEquals( Str::prefix( 'ControllerMain', 'Main' ), 'Controller' );
	}
	
	/**
	 * test extentsion
	 */
	public function testExtension() 
	{
		$this->assertEquals( Str::extension( 'test.php' ), 'php' );
		$this->assertEquals( Str::extension( 'test.sdf.sdf.md' ), 'md' );
		$this->assertEquals( Str::extension( 'test.sdf.......pdf' ), 'pdf' );
	}
	
	/**
	 * test extentsion
	 */
	public function testHash() 
	{
		ClanCats::$config->set( 'security.hash', 'sha1' );
		$this->assertEquals( strlen( Str::hash( 'testing around' ) ), 40 );
		
		ClanCats::$config->set( 'security.hash', 'md5' );
		$this->assertEquals( strlen( Str::hash( 'testing around' ) ), 32 );
	}
	
	/**
	 * test clean
	 */
	public function testClean() 
	{
		$this->assertEquals( Str::clean( '<>Hellö World!</>' ), 'Helloe World' );
		$this->assertEquals( Str::clean( '&3mk%çäöü' ), '3mkcaeoeue' );
		$this->assertEquals( Str::clean( ' Na       Tes t  ' ), 'Na Tes t' );
		$this->assertEquals( Str::clean( "/**\n\t* test clean\n*/" ), 'test clean' );
		$this->assertEquals( Str::clean( 'a|"bc!@£de^&$f g' ), 'abcdef g' );
	}
	
	/**
	 * test clean url strings
	 */
	public function testCleanUrl() 
	{
		$this->assertEquals( Str::clean_url( '<>Hellö World!</>' ), 'helloe-world' );
		$this->assertEquals( Str::clean_url( '-- s-a- -as/&EDö__ $' ), 's-a-as-edoe' );
		$this->assertEquals( Str::clean_url( ' - Ich bin nüscht   such: Ideal!' ), 'ich-bin-nuescht-such-ideal' );
		$this->assertEquals( Str::clean_url( 'Tom&Jerry' ), 'tom-jerry' );
	}
	
	/**
	 * test string replacements
	 */
	public function testStrReplace() 
	{
		$this->assertEquals( Str::replace( 'Hello :name', array( ':name' => 'World' ) ), 'Hello World' );
	}
	
	/**
	 * test string replacements
	 */
	public function testUpper() 
	{
		$this->assertEquals( Str::upper( 'Hellö Würld' ), 'HELLÖ WÜRLD' );
	}
	
	/**
	 * test string replacements
	 */
	public function testLower() 
	{
		$this->assertEquals( Str::lower( 'HELLÖ WÜRLD' ), 'hellö würld' );
	}
	
	/**
	 * test string replacements
	 */
	public function testReplaceAccents() 
	{
		$this->assertEquals( Str::replace_accents( 'HèllÖ Wörld ž' ), 'HellOe Woerld z' );
	}
	
	/**
	 * test string cut
	 */
	public function testCut() 
	{
		$this->assertEquals( Str::cut( 'some/of/my/url/?with=param', '?' ), 'some/of/my/url/' );
		$this->assertEquals( Str::cut( 'some/of/my/url/?with=param', '/' ), 'some' );
	}
	
	/**
	 * test string strip
	 */
	public function testStrip() 
	{
		$this->assertEquals( Str::strip( 'hellotestworld', 'test' ), 'helloworld' );
	}
	
	/**
	 * test string kfloor
	 */
	public function testKFloor() 
	{
		$this->assertEquals( Str::kfloor( 956 ), 956 );
		$this->assertEquals( Str::kfloor( 1000 ), '1K' );
		$this->assertEquals( Str::kfloor( 32951 ), '32K' );
	}
	
	/**
	 * test string bytes
	 */
	public function testBytes() 
	{
		$this->assertEquals( '956b', Str::bytes( 956 ) );
		$this->assertEquals( '42.4kb', Str::bytes( 43413 ) );
		$this->assertEquals( '423.96kb', Str::bytes( 434131 ) );
		$this->assertEquals( '41.4mb', Str::bytes( 43413313 ) );
		$this->assertEquals( '4.04gb', Str::bytes( 4341311313 ) );
		
		$this->assertEquals( '42kb', Str::bytes( 43413, 0 ) );
		$this->assertEquals( '423.956kb', Str::bytes( 434131, 3 ) );
		$this->assertEquals( '41.4022mb', Str::bytes( 43413313, 4 ) );
		$this->assertEquals( '41.4mb', Str::bytes( 43434513, 1 ) );
	}
}