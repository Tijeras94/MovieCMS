
apt-get update

chmod +x initdebug.sh

apt-get install -y apache2
apt-get install -y php5
apt-get install -y mysql-server
if [ -d "/etc/apache2/" ] 
then
	echo "Modifing apache2"
	mv /etc/apache2/apache2.conf /etc/apache2/apache2.conf.old
	cp apache2.conf /etc/apache2/apache2.conf
	
	mv /etc/apache2/sites-available/000-default.conf /etc/apache2/sites-available/000-default.conf.old
	cp apache-host.conf /etc/apache2/sites-available/000-default.conf
fi

if [ -d "/etc/php5/apache2/" ] 
then
	echo "Modifing PHP5"
    mv /etc/php5/apache2/php.ini /etc/php5/apache2/php.ini.old
	cp php.ini /etc/php5/apache2/php.ini
fi

if [ -d "/etc/php/7.0/apache2/" ] 
then
	echo "Modifing PHP7"
    mv /etc/php/7.0/apache2/php.ini /etc/php/7.0/apache2/php.ini.old
	cp php.ini /etc/php/7.0/apache2/php.ini
fi

if [ -d "/etc/mysql/" ] 
then
	echo "Modifing MYSQL"
    mv /etc/mysql/my.cnf /etc/mysql/my.cnf.old
	cp my.cnf /etc/mysql/my.cnf
fi

apt-get install php5-mysql
apt-get install php5-curl

service apache2 restart
service mysql restart