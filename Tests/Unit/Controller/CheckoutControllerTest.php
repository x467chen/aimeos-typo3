<?php


namespace Aimeos\Aimeos\Tests\Unit\Controller;


class CheckoutControllerTest
	extends \TYPO3\CMS\Core\Tests\UnitTestCase
{
	private $object;


	public function setUp()
	{
		\Aimeos\Aimeos\Base::getAimeos(); // initialize autoloader
		$config = \Aimeos\Aimeos\Base::getConfig();

		$context = new \Aimeos\MShop\Context\Item\Standard();
		$context->setView( new \Aimeos\MW\View\Standard() );
		$context->setConfig( $config );

		$this->object = $this->getAccessibleMock( 'Aimeos\\Aimeos\\Controller\\BasketController', ['getContext'] );

		$uriBuilder = $this->getMockBuilder( 'TYPO3\\CMS\\Extbase\\Mvc\\Web\\Routing\\UriBuilder' )->getMock();
		$request = $this->getMockBuilder( 'TYPO3\\CMS\\Extbase\\Mvc\\Web\\Request' )->getMock();
		$response = $this->getMockBuilder( 'TYPO3\\CMS\\Extbase\\Mvc\\Web\\Response' )
			->setMethods( ['getHeaders'] )
			->getMock();

		$this->object->expects( $this->any() )->method( 'getContext' )->will( $this->returnValue( $context ) );


		$uriBuilder->setRequest( $request );

		if( method_exists( $response, 'setRequest' ) ) {
			$response->setRequest( $request );
		}

		$this->object->_set( 'uriBuilder', $uriBuilder );
		$this->object->_set( 'response', $response );
		$this->object->_set( 'request', $request );

		$this->object->_call( 'initializeAction' );
	}


	public function tearDown()
	{
		unset( $this->object );
	}


	/**
	 * @test
	 */
	public function indexAction()
	{
		$name = '\\Aimeos\\Client\\Html\\Checkout\\Standard\\Standard';
		$client = $this->getMock( $name, array( 'getBody', 'getHeader', 'process' ), array(), '', false );

		$client->expects( $this->once() )->method( 'getBody' )->will( $this->returnValue( 'body' ) );
		$client->expects( $this->once() )->method( 'getHeader' )->will( $this->returnValue( 'header' ) );

		\Aimeos\Client\Html\Checkout\Standard\Factory::injectClient( $name, $client );
		$output = $this->object->indexAction();
		\Aimeos\Client\Html\Checkout\Standard\Factory::injectClient( $name, null );

		$this->assertEquals( 'body', $output );
	}


	/**
	 * @test
	 */
	public function confirmAction()
	{
		$name = '\\Aimeos\\Client\\Html\\Checkout\\Confirm\\Standard';
		$client = $this->getMock( $name, array( 'getBody', 'getHeader', 'process' ), array(), '', false );

		$client->expects( $this->once() )->method( 'getBody' )->will( $this->returnValue( 'body' ) );
		$client->expects( $this->once() )->method( 'getHeader' )->will( $this->returnValue( 'header' ) );

		\Aimeos\Client\Html\Checkout\Confirm\Factory::injectClient( $name, $client );
		$output = $this->object->confirmAction();
		\Aimeos\Client\Html\Checkout\Confirm\Factory::injectClient( $name, null );

		$this->assertEquals( 'body', $output );
	}


	/**
	 * @test
	 */
	public function updateAction()
	{
		$name = '\\Aimeos\\Client\\Html\\Checkout\\Update\\Standard';
		$client = $this->getMock( $name, array( 'getBody', 'getHeader', 'process' ), array(), '', false );

		$client->expects( $this->once() )->method( 'getBody' )->will( $this->returnValue( 'body' ) );
		$client->expects( $this->once() )->method( 'getHeader' )->will( $this->returnValue( 'header' ) );

		\Aimeos\Client\Html\Checkout\Update\Factory::injectClient( $name, $client );
		$output = $this->object->updateAction();
		\Aimeos\Client\Html\Checkout\Update\Factory::injectClient( $name, null );

		$this->assertEquals( 'body', $output );
	}
}