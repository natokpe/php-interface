<?php
declare(strict_types=1);

namespace Natokpe\PhpInterface;

/**
 * @package  Natokpe\PhpInterface
 * 
 * @access public
 *
 * @author  Nat Okpe <natokpe@gmail.com>
 *
 * @version 1.0.0
 * 
 * @license https://opensource.org/licenses/MIT MIT
 * 
 * @copyright Copyright (c) 2021, Nat Okpe
 */
class PhpInterface
{
    /**
     * @var string
     */
    protected $sapi_name = '';

    /**
     * @var string
     */
    protected $doc_root = '';

    /**
     * @var null|string
     */
    protected $request_method = null;

    /**
     * @var string
     */
    protected $php_self = '';

    /**
     * @var string
     */
    protected $cgi_spec = '';

    /**
     * @var string
     */
    protected $session_name = '';

    /**
     * @var int
     */
    protected $argc = -1;

    /**
     * @var bool
     */
    protected $env_shell = false;

    /**
     * 
     * @access public
     */
    public function __construct()
    {
        $this->sapi_name = php_sapi_name();

        if ( isset( $_SERVER[ 'DOCUMENT_ROOT' ] ) )
            $this->doc_root = $_SERVER[ 'DOCUMENT_ROOT' ];

        if ( isset( $_SERVER[ 'REQUEST_METHOD' ] ) )
            $this->request_method = $_SERVER[ 'REQUEST_METHOD' ];

        if ( isset( $_SERVER[ 'PHP_SELF' ] ) )
            $this->php_self = $_SERVER[ 'PHP_SELF' ];

        if ( isset( $_SERVER[ 'GATEWAY_INTERFACE' ] ) )
            $this->cgi_spec = $_SERVER[ 'GATEWAY_INTERFACE' ];

        if ( isset( $_SERVER[ 'SESSIONNAME' ] ) )
            $this->session_name = $_SERVER[ 'SESSIONNAME' ];

        if ( isset( $_SERVER[ 'argc' ] ) )
            $this->argc = $_SERVER[ 'argc' ];

        if ( isset( $_ENV[ 'SHELL' ] ) )
            $this->env_shell = true;
    }

    /**
     * returns the type of interface PHP is using to run
     * 
     * @access public
     * @return string type of interface
     */
    public function which() : string
    {
        return ( $this->isCli() ) ? 'cli' : 'web';
    }

    /**
     * returns true if PHP is using CLI to run
     * 
     * @access public
     * @return bool true if PHP is run in CLI otherwise false
     */
    public function isCli() : bool
    {
        if ( 'cli' === $this->sapi_name )
            return true;

        if ( true === $this->env_shell )
            return true;

        if ( 'Console' === $this->session_name )
            return true;

        if ( is_int( $this->argc ) && $this->argc >= 0 )
            return true;

        if ( '' === $this->doc_root )
            return true;

        if ( is_null( $this->request_method ) )
            return true;

        return false;
    }

    /**
     * returns true if PHP is using a web interface to run
     * 
     * @access public
     * @return bool true if PHP is run from a web interface otherwise false
     */
    public function isWeb() : bool
    {
        return ! $this->isCli();
    }

    /**
     * returns true if PHP is running from run from a CGI based interface
     * 
     * @access public
     * @return bool true if PHP is run in a CGI based interface otherwise false
     * @uses substr()
     */
    public function isCgi() : bool
    {
        if ( 'cgi' === substr ( $this->sapi_name, 0, 3 ) )
            return true;

        if ( 'cgi' === substr ( $this->sapi_name, -3 ) )
            return true;

        // If $_SERVER['GATEWAY_INTERFACE'] is set to something like 'CGI/1.1'
        if ( 'CGI' === substr ( $this->cgi_spec, 0, 3 ) )
            return true;

        // See https://mantisbt.org/bugs/view.php?id=5753
        if ( '' === $this->php_self )
            return true;

        return false;
    }

    /**
     * 
     * @access public
     * @static
     * @see which
     */
    public static function getType()
    {
        return ( new self() )->which();
    }
}
