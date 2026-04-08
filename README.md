# OperationGpt 

A powerful Laravel package that allows users to interact with their system database using natural language via a beautiful chat interface.

## Features
- **AI-Driven DB Operations**: Insert, Update, and Select data using natural language.
- **Security-First Architecture**: AI never executes raw SQL. It returns structured instructions validated against a strict whitelist.
- **Natural Language Reports**: Automatically generates HTML tables/reports from DB data.
- **Automatic Hashing**: Passwords in `insert` actions are automatically hashed.
- **Production Ready**: Built with SOLID principles, transactions, and robust logging.

## Installation

1. **Install via Composer**:
   ```bash
   composer require operation-gpt/operation-gpt
   ```

2. **Publish Configuration**:
   ```bash
   php artisan vendor:publish --provider="OperationGpt\OperationGpt\OperationGptServiceProvider"
   ```

3. **Configure OpenAI API Key**:
   Add your OpenAI key to your `.env` file:
   ```env
   OPENAI_API_KEY=sk-your-api-key
   OPERATION_GPT_MODEL=gpt-4o
   ```

4. **Define Allowed Tables**:
   Edit `config/operation-gpt.php` to whitelist the tables and columns you want the AI to access.

## Usage

Access the chat interface at:
`your-app.test/operation-gpt`

### Example Commands:
- "Add a new admin user named Ahmed with email ahmed@test.com"
- "Change the role of user with email ahmed@test.com to editor"
- "Show me a list of all users registered this month"

## 🛡 Security
- **Strict Whitelist**: AI can only touch tables and columns you explicitly allow in the config.
- **No Raw SQL**: The package uses Laravel's Query Builder with parameter binding.
- **Transaction Support**: If a multi-step operation fails, all changes are rolled back.

## License
MIT
