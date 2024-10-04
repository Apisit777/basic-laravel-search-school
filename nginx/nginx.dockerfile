FROM nginx:1.19.4

ADD docker/nginx/default.conf /etc/nginx/conf.d/default.conf

RUN apt-get update && apt-get install -y openssl
RUN openssl req -x509 -nodes -days 365 -newkey rsa:2048 \
    -keyout /etc/ssl/private/nginx-selfsigned.key -out /etc/ssl/certs/nginx-selfsigned.crt \
    -subj "/C=TH/ST=Bangkok/L=Bangkok/O=MyCompany/OU=IT/CN=your-domain.com/emailAddress=admin@your-domain.com"
# RUN openssl req -x509 -nodes -days 365 -newkey rsa:2048 -keyout nginx-selfsigned.key -out nginx-selfsigned.crt

COPY ./src/public /var/www/public