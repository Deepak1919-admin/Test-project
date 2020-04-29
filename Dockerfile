FROM ubuntu
RUN apt-get update
RUN apt-get -y install tzdata libapache2-mod-php apache2 mysql-server php 
ADD . /var/www/html
ENTRYPOINT apachectl -D FOREGROUND
ENV name deepak
