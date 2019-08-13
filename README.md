# goes-tools-panel

Admin panel and viewer for GOES Tools: https://github.com/pietern/goestools

Note: These instructions reference PHP 7.3. Modify as needed for newer versions. A working installion of GOES Tools is assumed.

## Video Demo
https://youtu.be/jbbD2js6OFY

## Requirements
* Nginx
* PHP
* FFmpeg (optional)

## Installation

**1**) Install ffmpeg
```
sudo apt-get install ffmpeg
```

Note: Optional but recommended if you have a PI 3 or 4.

**2**) Remove apache (comes preinstalled on some distros):
```
sudo apt-get remove apache2
```

**3**) Install nginx:
```
sudo apt-get install nginx
```

**4**) Install PHP
```
sudo apt-get install php7.3-fpm php7.3-mbstring php7.3-mysql php7.3-curl php7.3-gd php7.3-curl php7.3-zip php7.3-xml -y
```

**5**) Modify php.ini (/etc/php/7.3/fpm/php.ini):

Find:
```
max_execution_time = 30
```

Replace:
```
max_execution_time = 300
```

**6**) Modify nginx (/etc/nginx/sites-available/default):

Find:
```
root /var/www/html;
```

Replace:
```
root /var/www;
```

Find:
```
index index.html index.htm;
```

Replace:
```
index index.php index.html index.htm;
```

Find:
```
       location ~ \.php$ {
       include snippets/fastcgi-php.conf;
               # With php5-cgi alone:
               fastcgi_pass 127.0.0.1:9000;
               # With php5-fpm:
               fastcgi_pass unix:/var/run/php5-fpm.sock;
        }
```
	
Replace (modify for php version as needed):
```
location ~ \.php$ {
	include snippets/fastcgi-php.conf;
	fastcgi_pass unix:/var/run/php/php7.3-fpm.sock;
		fastcgi_read_timeout 300; 
	}
```
       
**7**) Copy GOES Tools Panel system files to:
```
/etc/logrotate.d/goestools
/etc/systemd/system/goesproc.service
/etc/systemd/system/goesrecv.service
/home/pi/goesproc-goesr.conf
```

Note: Ensure that *your* goes goesrecv.conf is in /home/pi

**8**) Enable services:
```
sudo systemctl enable goesrecv.service
sudo systemctl enable goesproc.service
```


**9**) Copy GOES Tools Panel www files to:
/var/www

**10**) Edit /var/www/config.php (instructions inside file)

**11**) Restart:
```
sudo reboot
```
