FROM ubuntu
RUN apt-get update
RUN apt-get -y install tzdata 
RUN apt-get -y install libapache2-mod-php 
RUN apt-get -y install apache2 
RUN apt-get -y install mysql-server 
RUN apt-get -y install php
ADD . /var/www/html
ENTRYPOINT apachectl -D FOREGROUND
ENV name deepak
