# MovieCMS
A movie content management system


## Config Ubuntu 14.04 LTS Server 

``` 
# Execute Script

cd /
apt-get update
apt-get -y install git 
git clone https://Tijeras94:%40%40Tijeras94@github.com/Tijeras94/MovieCMS.git
cd MovieCMS/cnf
chmod +x init.sh
./init.sh

```
## MYSQL allow root user remote
```
GRANT SELECT ON *.* TO 'root'@'%';
SET PASSWORD FOR 'root'@'%' = PASSWORD('toor');

```
