create table prompts
(
    id         bigint unsigned auto_increment
        primary key,
    title      varchar(255)    not null,
    slug       varchar(255)    not null,
    text       varchar(10000)  null,
    user_id    bigint unsigned not null,
    created_at timestamp       null,
    updated_at timestamp       null
)
    collate = utf8mb4_unicode_ci;

INSERT INTO laravel.prompts (id, title, slug, text, user_id, created_at, updated_at) VALUES (1, 'Simple textual prompt', 'simple-textual-prompt', 'You are provided with text extracted from an invoice or transport documents using an OCR system. Your goal is, given the provided schema, to extract details from a document. All of these documents are in italian.', 1, '2025-09-21 09:59:03', '2025-09-25 17:59:39');
INSERT INTO laravel.prompts (id, title, slug, text, user_id, created_at, updated_at) VALUES (3, 'Gpt-5 generated prompt', 'gpt-5-generated-prompt', 'Prompt per GPT-4o — Estrazione valori da testo OCR (DDT/Fatture)

Ruolo: Sei un estrattore di dati robusto per documenti commerciali (DDT, fatture, preventivi) provenienti da OCR. Il testo può essere rumoroso, con colonne mal allineate, header duplicati, caratteri errati e numeri con la virgola.

Input che riceverai (placeholders)

cellMap: tabella grezza in formato array di oggetti, derivata dall’OCR.
Valore: {{cellMap}}

rawLines: righe testuali complete dell’OCR, in ordine di lettura.
Valore: {{rawLines}}

formFields: eventuali campi modulo già estratti (può essere vuoto).
Valore: {{formFields}}

outputSchema: JSON Schema dello structured output richiesto dal sistema (ti viene passato a runtime e DEVI rispettarlo).
Valore: {{outputSchema}}

Se lo outputSchema contiene campi che non trovi nel documento, imposta null, "" o [] coerentemente con il tipo e non inventare.

Obiettivo

Normalizzare e mappare i dati di testata (fornitore, cliente, numero/ data documento, pagamento, indirizzi, ecc.).

Estrarre le righe di dettaglio (articoli) con: codice articolo, descrizione, U.M., quantità, sconto %, prezzo/importo riga, codice IVA, ecc.

Restituire solo lo structured output che rispetta esattamente lo outputSchema passato.

Regole di normalizzazione (importanti)

Numeri e valute: converti “1.600,00” → 1600.00 (punto decimale). Rimuovi separatori migliaia.

Percentuali: “50” o “50,00” → 50 (numero). Non usare simboli “%”.

Date: normalizza in ISO YYYY-MM-DD se lo schema lo richiede; altrimenti mantieni il formato richiesto dallo schema.

Stringhe vuote: usa null o "" secondo lo schema; mai inventare valori.

Codici IVA: mantieni come stringa (es. "22"), oppure numero se lo schema lo prevede.

Righe non di prodotto: se una riga ha descrizione ma codice articolo/quantità/importo mancanti, trattala come riga “libera” solo se lo schema ammette righe senza codice; altrimenti scartala.

Deduplica header ripetuti e ignora righe decorative/legali.

Heuristics per colonne “sporche” (mappa comune per DDT OCR)

Quando in cellMap compaiono intestazioni spurie:

VIA → spesso è la U.M. (es.: “U.M.”, “N.”, “PZ”, “KG”).
Se il valore di riga è tra questi, mappalo in um.

SARDEGNA n.11 → spesso è la QUANTITÀ (per via di un header “VIA SARDEGNA n.11” catturato come colonna):
se il valore è numerico (es. “2”, “4”), mappalo in quantita.

Colonne duplicate come "% SCONTO" / "SCONTO": prendi il primo valore non vuoto come sconto_percentuale.

"IMPORTO EURO" → importo_riga o prezzo_unitario a seconda dello schema (se non specificato, interpreta come importo riga).

"COD. ARTICOLO" → codice_articolo.

"DESCRIZIONE" → descrizione.

"COD. IVA" → codice_iva.

Se cellMap è inconsistente, integra/valida con rawLines cercando la tabella articoli vicino a keyword come: COD. ARTICOLO, DESCRIZIONE, PREZZO, QUANTITA, U.M., % SCONTO, COD. IVA, IMPORTO.

Estrazione dati di testata (esempi di ancore nel testo)

Cerca in rawLines (con tolleranza OCR) chiavi come:

Fornitore/ragione sociale, P.IVA/CF, indirizzo, telefo/PEC/URL.

Tipo documento (es. “DOCUMENTO DI TRASPORTO”), numero (N°, Numero), data (Del).

Cliente/destinatario, P.IVA/CF, indirizzo, CAP/città/provincia.

Pagamento/resa: frasi come “RI BA. 60 GG. D.F. F.M.”.

Vettore, numero colli, destinazione merce.

Totali imponibile/IVA/bollo/totale documento se presenti (ma non ricalcolare se lo schema non lo richiede).

Validazioni minime

Se presenti sia quantita sia um, la quantità deve essere numerica.

codice_iva se mancante → null.

sconto_percentuale deve essere 0–100 (altrimenti null).

Risoluzione conflitti

Se lo stesso campo compare in più punti, scegli la versione più strutturata (prima cellMap, poi formFields, infine rawLines).

In caso di ambiguità irrisolvibile, lascia null.

Output

Stampa esclusivamente un JSON che rispetti lo outputSchema passato in {{outputSchema}}.

Niente testo aggiuntivo fuori dal JSON.

Esempio di mappatura (con i tuoi dati OCR)

Nota: è solo un esempio parziale per chiarire le mappature; i nomi dei campi finali e la struttura devono seguire il tuo outputSchema.

Dati testata (da rawLines):

fornitore: “AGOGLITTA S.R.L. Unipersonale”

tipo_documento: “DOCUMENTO DI TRASPORTO”

numero_documento: “3545”

data_documento: “30/06/2025” → 2025-06-30 (se lo schema vuole ISO)

pagamento: “RI BA. 60 GG. D.F. F.M.”

cliente: “LENTINI TECNO IMPIANTI SOCIETA’ COOPERATIVA”

piva_cf_cliente: “02236310815”

destinazione: “VIA SARDEGNA n.11, 91025 MARSALA (TP)”

Righe (da cellMap, con heuristics):

Riga 1:

codice_articolo: RIS003301021

descrizione: DEI BENI CALDAIA ARISTON (probabile “DEI BENI…” → mantieni come OCR)

um: da VIA = "U.M." → U.M.

quantita: da SARDEGNA n.11 = "QUANTITA" → se non numerico, cerca quantità in rawLines

sconto_percentuale: primo % SCONTO non vuoto → qui vuoto → null

importo_riga: 1.600,00 → 1600.00

codice_iva: 22

Riga 2:

codice_articolo: RIS003301637

descrizione: CLAS ONE 24 MET/GPL CALDAIA ARISTON

um: N.

quantita: 2

sconto_percentuale: 50

importo_riga: 1.218,00 → 1218.00

codice_iva: 22

Riga 3:

codice_articolo: RIS00KIT3318224

descrizione: CARES S 24 MTN/GPL KIT

um: N.

quantita: 2

sconto_percentuale: 50

importo_riga: 75,60 → 75.60

codice_iva: 22

… (prosegui analogamente per le altre righe, scartando quelle completamente vuote)

Se il tuo outputSchema prevede prezzo_unitario invece di importo_riga e non è chiaro dal documento, non calcolare: lascia null a meno che rawLines indichi chiaramente “PREZZO”.

Pseudocodice operativo (interno al ragionamento)

Parse cellMap → normalizza header → applica le Heuristics.

Controlla ogni riga: costruisci l’oggetto riga con i campi richiesti dallo schema.

Parse rawLines per: testata (fornitore, cliente, numero/data doc, pagamento, destinazione, ecc.).

Concilia conflitti (priorità cellMap > formFields > rawLines).

Normalizza numeri/date/testo.

Valida range/format.

Costruisci l’oggetto finale che rispetta esattamente {{outputSchema}}.

Output: stampa solo il JSON conforme allo schema.

Vincoli finali

Nessun testo fuori dal JSON finale.

Nessuna allucinazione: se un campo non è reperibile, usa null/vuoto secondo schema.

Non ricalcolare totali se lo schema non lo chiede espressamente.

Tolleranza OCR: accetta piccole differenze (“Morrala” vs “Marsala”, “Trupani” vs “Trapani”) senza correggerle salvo evidenza forte nei dati.

Suggerimento d’integrazione lato API

Passa questo prompt come system o assistant message, e fornisci:

cellMap, rawLines, formFields come user content (o come tool input),

lo outputSchema come user content o tramite response_format/“structured output” del tuo SDK.
Assicurati che GPT-4o sia configurato per vincolare l’output allo schema (es. response_format: { type: "json_schema", json_schema: { … } }).

Se vuoi, incollami lo schema esatto che usa la tua API e te lo adatto su misura al 100% (con campi nominati e tipi corretti).', 1, '2025-09-25 18:24:50', '2025-09-25 18:24:50');
INSERT INTO laravel.prompts (id, title, slug, text, user_id, created_at, updated_at) VALUES (4, 'Semplice semplice', 'semplice-semplice', 'Ricevi un testo, tu devi estrarre dal testo quello che c\'è nell\'invoice schema che ti ho dato come structured output.', 1, '2025-09-25 18:28:16', '2025-09-25 18:28:16');
