Set WshShell = CreateObject("WScript.Shell")
WshShell.CurrentDirectory = "C:\xampp\htdocs\medi-pos"

' Start MySQL 
WshShell.Run "c:\xampp\mysql\bin\mysqld.exe --defaults-file=c:\xampp\mysql\bin\my.ini --standalone", 0, False

' Start Apache 
WshShell.Run "c:\xampp\apache\bin\httpd.exe", 0, False

' Start Laravel Server
WshShell.Run "c:\xampp\php\php.exe artisan serve --port=8000", 0, False

' Start Laravel Background Scheduler (Auto-Sync)
WshShell.Run "c:\xampp\php\php.exe artisan schedule:work", 0, False

WScript.Sleep 3000

' Open Chrome in app mode
WshShell.Run "cmd /c start chrome --app=http://127.0.0.1:8000", 0, False
