<?php
session_start();
require_once "Session.php";

echo Session::showFlash("form");