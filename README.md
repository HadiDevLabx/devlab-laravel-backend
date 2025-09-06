# Laravel E-commerce Backend API

## Quick Setup

### Windows
Run the setup script:
```bash
setup.bat
```

### Manual Setup
1. Install dependencies:
```bash
composer install
```

2. Copy environment file:
```bash
cp .env.example .env
```

3. Generate application key:
```bash
php artisan key:generate
```

4. Configure database in `.env` file (SQLite is default)

5. Run migrations and seed data:
```bash
php artisan migrate:fresh --seed
```

6. Start the server:
```bash
php artisan serve --port=8000
```

## API Endpoints

### Authentication
- `POST /api/register` - Register new user
- `POST /api/login` - Login user
- `POST /api/logout` - Logout user
- `GET /api/user` - Get current user

### Products
- `GET /api/products` - Get all products (with filtering/sorting)
- `GET /api/products/{id}` - Get product by ID
- `GET /api/products/handle/{handle}` - Get product by slug/handle

### Categories
- `GET /api/categories` - Get all categories
- `GET /api/categories/{id}` - Get category by ID
- `GET /api/categories/slug/{slug}` - Get category by slug

### Cart (Authenticated)
- `GET /api/cart` - Get user's cart
- `POST /api/cart` - Add item to cart
- `PUT /api/cart/{id}` - Update cart item
- `DELETE /api/cart/{id}` - Remove cart item
- `DELETE /api/cart` - Clear cart

### Orders (Authenticated)
- `GET /api/orders` - Get user's orders
- `POST /api/orders` - Create new order
- `GET /api/orders/{id}` - Get specific order

## Database

The application uses SQLite by default for easy setup. The database file will be created at `database/database.sqlite`.

## Test Data

The seeder creates:
- 5 categories (Jackets, T-Shirts, Jeans, Shoes, Accessories)
- 5 sample products with images
- 1 test user (test@example.com / password)