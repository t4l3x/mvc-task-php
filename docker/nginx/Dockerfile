# Use the latest Nginx base image
FROM nginx:latest

# Copy the Nginx configuration file

COPY ./default.conf /etc/nginx/conf.d/default.conf

# Copy the application code to the appropriate directory
COPY . /var/www/html

# Expose port 80 for HTTP traffic
EXPOSE 80

# Start Nginx
CMD ["nginx", "-g", "daemon off;"]