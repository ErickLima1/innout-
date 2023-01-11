<?php
session_start();
RequireValidSession();

loadTemplateView('manager_report', []);
