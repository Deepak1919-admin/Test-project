FROM ubuntu
RUN apt-get update
RUN apt-get -y install tzdata
RUN apt-get -y install apache2 libapache2-mod-php	
ADD . /var/www/html
ENTRYPOINT apachectl -D FOREGROUND
ENV name deepak
