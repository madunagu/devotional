@echo off

REM **********************************************************************
REM * PLACE This file in a folder that is already on your PATH
REM * Or just put it in your C:\Windows folder as that is on the
REM * Serch path by default
REM * - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
REM * EDIT THE NEXT 3 Parameters to fit your installed WAMPServer
REM * for example I installed WAMPServer on the D: drive you may
REM * have used C:
REM * - baseWamp : is the drive and folder where you installed WAMPServer
REM * - defaultPHPver : is the version of PHP that will be pathed
REM *                   if no Parameter is put on the bat file
REM * - composerInstalled : Where I insatlled composerInstalled
REM * - phpFolder : The folder structure that contains the Multiple
REM *               possible version of PHP I have installed
REM **********************************************************************


set baseWamp=D:\wamp
set defaultPHPver=7.0.23
set composerInstalled=%baseWamp%\composer
set phpFolder=\bin\php\php

if %1.==. (
    set phpver=%baseWamp%%phpFolder%%defaultPHPver%
) else (
    set phpver=%baseWamp%%phpFolder%%1
)

PATH=%PATH%;%phpver%
php -v
echo ---------------------------------------------------------------


REM IF PEAR IS INSTALLED IN THIS VERSION OF PHP

IF exist %phpver%\pear (
    set PHP_PEAR_SYSCONF_DIR=D:\wamp\bin\php\php%phpver%
    set PHP_PEAR_INSTALL_DIR=D:\wamp\bin\php\php%phpver%\pear
    set PHP_PEAR_DOC_DIR=D:\wamp\bin\php\php%phpver%\docs
    set PHP_PEAR_BIN_DIR=D:\wamp\bin\php\php%phpver%
    set PHP_PEAR_DATA_DIR=D:\wamp\bin\php\php%phpver%\data
    set PHP_PEAR_PHP_BIN=D:\wamp\bin\php\php%phpver%\php.exe
    set PHP_PEAR_TEST_DIR=D:\wamp\bin\php\php%phpver%\tests

    echo PEAR INCLUDED IN THIS CONFIG
    echo ---------------------------------------------------------------
) else (
    echo PEAR DOES NOT EXIST IN THIS VERSION OF php
    echo ---------------------------------------------------------------
)

REM IF COMPOSER EXISTS ADD THAT TOO
REM **************************************************************
REM * IF A GLOBAL COMPOSER EXISTS ADD THAT TOO
REM *
REM * This assumes that composer is installed in /wamp/composer
REM *
REM **************************************************************
IF EXIST %composerInstalled% (
    ECHO COMPOSER INCLUDED IN THIS CONFIG
    echo ---------------------------------------------------------------
    set COMPOSER_HOME=%baseWamp%\composer
    set COMPOSER_CACHE_DIR=%baseWamp%\composer

    PATH=%PATH%;%baseWamp%\composer

    rem echo TO UPDATE COMPOSER do > composer self-update
    echo ---------------------------------------------------------------
) else (
    echo ---------------------------------------------------------------
    echo COMPOSER IS NOT INSTALLED
    echo ---------------------------------------------------------------
)

set baseWamp=
set defaultPHPver=
set composerInstalled=
set phpFolder=
