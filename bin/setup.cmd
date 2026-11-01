@echo off
rem Windows/XAMPP setup. Requires Git Bash (installed with Git for Windows).
rem Start Apache + MySQL in XAMPP and create an empty database "dr_hala" first.
set "WP=bin/wp.cmd"
bash "%~dp0setup.sh"
