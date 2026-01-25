# CLAUDE.md

This file provides guidance to Claude Code (claude.ai/code) when working with code in this repository.

## Project Overview

OCR-SAAS is a Laravel 11 application for document OCR extraction and evaluation. It uses AWS Textract for text extraction and OpenAI (via Prism) for structured data extraction with dynamic JSON schemas.

## Common Commands

```bash
# Development (starts all services: artisan serve, queue:listen, pail, vite dev)
composer run dev

# Run tests
./vendor/bin/pest

# Code formatting
vendor/bin/pint

# Build frontend assets
npm run build

# Database migrations
php artisan migrate
```

## Architecture

### Core Processing Pipeline

1. **AwsTextractService** (`app/Services/AwsTextractService.php`) - Extracts raw text, tables, and form fields from documents via AWS Textract
2. **OpenAIService** (`app/Services/OpenAIService.php`) - Uses Prism library to extract structured data with dynamic JSON schemas
3. **DetailSchemaService** (`app/Services/DetailSchemaService.php`) - Builds Prism ObjectSchema from DocumentDetails for dynamic schema generation
4. **EvaluationService** (`app/Services/EvaluationService.php`) - Scores extractions against ground truth using Jaccard similarity, number, and date comparison

### Key Actions

- **RunExtractionAction** (`app/Actions/RunExtractionAction.php`) - Orchestrates the full extraction flow: Textract → OpenAI → ExtractedFields
- **RunBenchmarkAction** (`app/Actions/RunBenchmarkAction.php`) - Evaluates extraction accuracy against GroundTruth

### Domain Models

- **Document** - Uploaded files (PDF/images) with media library integration
- **DocumentDetail** - Field schema definitions (name, type: String/Number/Date, format)
- **DetailSet** - Groups DocumentDetails for document types
- **Prompt** - Custom extraction prompts
- **Run** - Single extraction execution (Document + Prompt)
- **ExtractedField** - Extracted values from a Run
- **GroundTruth** - Expected values for validation
- **BenchmarkResult** - Evaluation metrics

### Service Interfaces

- `OCRService` - Interface for OCR providers
- `AIService` - Interface for AI/LLM providers

### Facades

- `DetailSchema` - Access DetailSchemaService
- `Evaluation` - Access EvaluationService

### Enums

- `DetailType` - String, Number, Date
- `DetailFormat` - Field formatting options

## Tech Stack

- **Backend**: Laravel 11 (PHP 8.2+)
- **Admin Panel**: Filament v3.2 + Livewire v3.4
- **Frontend**: Tailwind CSS v4 + Vite
- **OCR**: AWS Textract
- **AI**: OpenAI GPT-4o via Prism library
- **Testing**: Pest
- **Media**: Spatie Laravel MediaLibrary
- **PDF Processing**: Spatie PDF-to-Image

## Environment Configuration

Key environment variables:
- `AWS_ACCESS_KEY_ID`, `AWS_SECRET_ACCESS_KEY`, `AWS_DEFAULT_REGION`, `AWS_BUCKET` - AWS Textract
- `OPENAI_API_KEY` - OpenAI API
- `QUEUE_CONNECTION` - Use `database` for async job processing
