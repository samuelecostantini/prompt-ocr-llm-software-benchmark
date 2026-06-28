# Prompt-OCR LLM Software Benchmark

**The next-gen open-source platform for benchmarking OCR and LLM-powered document extraction workflows. Designed for researchers and power users.**

<p align="center">
  <img src="https://user-images.githubusercontent.com/1022966514/placeholder-app-logo.png" alt="Prompt-OCR LLM Benchmark" width="350"/>
</p>

---

## Overview

Welcome to **Prompt-OCR LLM Software Benchmark**, a modern SaaS platform for evaluating the true power of AI for document extraction. Whether you’re comparing AWS Textract, OpenAI (via Prism), or custom prompts, this highly extensible Laravel 11 application makes it easy to **upload documents, define field schemas, run LLM-powered extractions, and score results vs. ground truth**.

Built for research, transparent benchmarking, and integration into your own document AI workflows.

---

## 🛠️ Tech Stack

- **PHP 8.2+** & Laravel 11
- Blade & Tailwind CSS v4 (beautiful, reactive admin)
- Filament Admin v3 + Livewire v3.4 (ultra-fast SPA)
- **AWS Textract** for raw OCR
- **OpenAI GPT-4o** for advanced, schema-driven extraction (via Prism)
- Spatie Laravel MediaLibrary & PDF-to-Image
- Pest for Testing

---

## Codebase Structure

### Core Processing Pipeline

```
app/
 ├─ Services/
 │   ├─ AwsTextractService.php     <== Raw OCR via AWS Textract
 │   ├─ OpenAIService.php         <== Structured data w/ Prism & OpenAI LLM
 │   ├─ DetailSchemaService.php   <== Dynamic JSON schema construction
 │   └─ EvaluationService.php     <== Field-level evaluation & metrics
 ├─ Actions/
 │   ├─ RunExtractionAction.php   <== Orchestrates full extraction pipeline
 │   └─ RunBenchmarkAction.php    <== Evaluates extractions vs. ground truth
 ├─ Models/
 │   Document.php, Run.php, ExtractedField.php, etc.
```

### Domain Concepts

- **Document**: PDF/image upload, tagged & versioned, with media attachments
- **DocumentDetail**: Schema fields (name, type e.g. string/number/date)
- **DetailSet**: Collection of DocumentDetails for a doc type
- **Prompt**: Custom system/user prompts for LLM extraction
- **Run**: A single extraction execution (Document + Prompt)
- **ExtractedField**: Individual LLM-extracted values
- **GroundTruth**: True/expected values for field validation
- **BenchmarkResult**: Evaluation metrics (Jaccard, numerical, dates)

### Interfaces & Extensibility

- `OCRService`: Plug-in your own OCR providers
- `AIService`: Support any LLM or pipeline
- Facades: `DetailSchema`, `Evaluation` for schema/eval operations

### Key Features

-  **Document-driven UI**: Upload, schema config, and prompt association in a breeze
-  **Asynchronous Job Processing**: All extractions/refinements run as jobs (support for database queue)
-  **Benchmarking Dashboard**: Out-of-the-box stats for Jaccard/score metrics per field & doc type
-  **MediaLibrary & PDF Rendering**: Visualize uploaded docs and page splits natively
-  **Modern Admin**: Fully reactive, themeable, and ready for custom expansion

---

## Quickstart

```bash
git clone https://github.com/SamueleCostantini/prompt-ocr-llm-software-benchmark.git
cp .env.example .env
# Edit env for your AWS + OpenAI + queue credentials
composer install
npm install && npm run build

php artisan migrate
composer run dev # starts Laravel server, queues, Vite frontend etc.
```
Navigate to `http://localhost:8000` and login with your admin credentials.

---

## Example Workflow

1. **Upload a Document**: PDF/image support, powered by Spatie's MediaLibrary.
2. **Define DetailSet**: Specify the schema (fields, types, formats) for extraction.
3. **Create Prompts**: Experiment with different system/user prompts (OpenAI/Prism).
4. **Run Extraction**: LLM pulls structured data based on your schema, after AWS Textract OCR.
5. **Validate vs. Ground Truth**: Add or import expected results.
6. **Benchmark**: View rich metrics, compare runs and tune prompts for optimal extraction F1/Jaccard scores.

---

## Architecture in Depth

- **Services/**  
  Core pipeline logic (AWS OCR, LLM extraction, schema/evaluation service)
- **Models/**  
  High-level data objects: Document, DetailSet, ExtractedField, Run, etc.
- **Actions/**  
  Business logic for extraction & benchmarking orchestration
- **Extensible Interfaces** (`app/Interfaces`):  
  For plugging in alternate OCR or LLM providers  
- **Admin & Views**  
  Filament-powered SPA for fluid doc management and metrics

---

## Environment Variables

- `AWS_ACCESS_KEY_ID`, `AWS_SECRET_ACCESS_KEY`, `AWS_DEFAULT_REGION`, `AWS_BUCKET`
- `OPENAI_API_KEY`
- `QUEUE_CONNECTION` (`database` recommended for async jobs)

---

## Documentation & Further Reading

- Rich inline code comments & services
- See `CLAUDE.md` for AI/coding assistant usage within the repo
- [Laravel Docs](https://laravel.com/docs)
<!-- (If you have a thesis PDF, link it here!) -->

---

## ❤️ Credits

Developed by [Samuele Costantini](https://github.com/SamueleCostantini) and contributors.

---

## License

MIT License – free for research, benchmarking, and your own wild LLM document adventures!
