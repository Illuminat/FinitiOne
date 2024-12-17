## Installation
1. Clone the repository:
   ```bash
   git clone https://github.com/username/repo.git
   ```
2. Navigate to the project directory:
   ```bash
   cd repo
   ```
3. Install dependencies:
   ```bash
   composer install
   ```
   _Or use your preferred dependency manager_

## Usage
1. Update the `.env` file with appropriate configuration values.
2. Run the Laravel development server:
   ```bash
   php artisan serve --port={port}
   ```
   Replace `{port}` with the desired port number (e.g., 8000).
3. Start Horizon for managing queues:
   ```bash
   php artisan horizon
   ```
4. Open your browser and navigate to:
   ```
   http://localhost:{port}/horizon
   ```
   Replace `{port}` with the port number used to serve the application.

   You will see your job queue dashboard to monitor and manage your background tasks.

### Laravel Command: `supplier:generate_report`
This command is used to generate supplier reports in the system.

**Usage:**
```bash
php artisan supplier:generate_report {--queue=low}
```
- `--queue`: Specifies the queue priority (default is `low`).

This command helps to process and generate supplier reports efficiently, allowing optional queue priority management.

### Laravel Command: `billing:process-transaction`
This command processes a billing transaction with the specified amount and currency.

**Usage:**
```bash
php artisan billing:process-transaction {amount} {currency} {--queue=default}
```
- `amount`: The transaction amount to be processed.
- `currency`: The currency of the transaction (e.g., USD, EUR).
- `--queue`: Specifies the queue priority (default is `default`).

This command enables smooth and prioritized billing transaction processing based on the specified amount and currency.

### Laravel Command: `user:welcome-email`
This command sends a welcome email to a user with customizable parameters.

**Usage:**
```bash
php artisan user:welcome-email {email} {subject="Welcome to Our Service"} {body="Thank you for signing up for our service"} {--retry=3} {--queue=default}
```
- `email`: The recipient's email address.
- `subject`: The subject of the email (default is "Welcome to Our Service").
- `body`: The body content of the email (default is "Thank you for signing up for our service").
- `--retry`: Number of retry attempts for sending the email (default is `3`).
- `--queue`: Specifies the queue priority (default is `default`).

This command allows sending user-specific welcome emails with configurable subject, body, and retry options.