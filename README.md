## Setup
```bash
# Clone the repo
git clone https://github.com/devboyarif/leave-management-system.git

# Install composer dependency
composer install

# Install node modules 
npm install / yarn

# Copy environment file
cp .env.example .env

# Set the Application key
php artisan key:generate

# setup the database credentials and migrate database with seeders
php artisan migrate --seed

```
