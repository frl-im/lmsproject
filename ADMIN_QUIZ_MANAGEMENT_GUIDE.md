# 📝 Admin Quiz Management Guide
**Date:** January 21, 2026  
**Status:** ✅ COMPLETE

---

## 🎯 Cara Menambahkan Quiz untuk Lesson

Ada 3 cara untuk mengelola soal kuis di admin:

---

## **Method 1: Dari Lesson List (Recommended)**

### Step 1: Go to Lessons Management
```
Admin Dashboard → Manajemen Materi & Kuis
http://127.0.0.1:8000/admin/lessons
```

### Step 2: Lihat Daftar Lessons
Anda akan melihat tabel dengan semua lessons:
- **Judul** (Title)
- **Modul** (Module Name)
- **Tipe** (Materi/Kuis) - ditandai dengan badge
- **XP** Reward
- **Aksi** (Action buttons)

### Step 3: Cari Lesson Kuis
Cari lesson dengan tipe **"kuis"** (badge ungu)

### Step 4: Klik Button "📝 Soal"
Di kolom **Aksi**, klik tombol **"📝 Soal"** untuk lesson tersebut

```
[Edit] [📝 Soal] [Hapus]  ← Cari tombol ini untuk kuis
```

### Step 5: Tampilannya seperti ini:
Anda akan dibawa ke halaman **Bank Soal** untuk lesson tersebut

---

## **Method 2: Dari Lesson Edit Page**

### Step 1: Buka Lesson untuk Diedit
```
Admin Dashboard → Manajemen Materi & Kuis → Click [Edit]
```

### Step 2: Pada halaman Edit Lesson
Jika lesson type adalah **"kuis"**, akan ada button di bawah:

```
┌────────────────────────────────┐
│  📝 Kelola Soal Kuis           │  ← Tombol ini akan muncul jika type = kuis
├────────────────────────────────┤
│  [Batal]  [Perbarui]           │
└────────────────────────────────┘
```

### Step 3: Klik "📝 Kelola Soal Kuis"
Akan dibawa ke halaman Bank Soal

---

## **Method 3: Direct URL**

Jika Anda tahu lesson ID, bisa direct akses:

```
http://127.0.0.1:8000/admin/lessons/{lesson_id}/quiz
```

Contoh untuk lesson ID 13:
```
http://127.0.0.1:8000/admin/lessons/13/quiz
```

---

## 📚 Bank Soal - Interface Penjelasan

Setelah masuk ke Bank Soal, Anda akan melihat:

### **Header**
```
Bank Soal: [Lesson Title]     [+ Tambah Soal]
```

### **Tabel Soal**
| No | Pertanyaan | Jawaban Benar | Poin | Aksi |
|----|-----------|---------------|------|------|
| 1  | Apa itu SQL? | A | 10 | [Edit] [Hapus] |
| 2  | SELECT...? | B | 15 | [Edit] [Hapus] |

### **Jika Belum Ada Soal**
```
┌────────────────────────────────────┐
│ Belum ada soal kuis.               │
│ [Tambah soal sekarang]             │
└────────────────────────────────────┘
```

---

## ✏️ Menambahkan Soal Baru

### Step 1: Klik "+ Tambah Soal"
Di halaman Bank Soal, klik button **"+ Tambah Soal"** (biru)

### Step 2: Form Tambah Soal
Anda akan melihat form dengan field:

#### **Pertanyaan** (Wajib)
```
┌──────────────────────────────────┐
│ Pertanyaan *                     │
├──────────────────────────────────┤
│ [Text area untuk pertanyaan]     │
│ "Tuliskan pertanyaan kuis..."    │
└──────────────────────────────────┘
```

#### **Opsi Jawaban A-D** (Wajib - 4 field)
```
┌──────────────┬──────────────┐
│ Opsi A *     │ Opsi B *     │
├──────────────┼──────────────┤
│ [Jawaban A]  │ [Jawaban B]  │
└──────────────┴──────────────┘
┌──────────────┬──────────────┐
│ Opsi C *     │ Opsi D *     │
├──────────────┼──────────────┤
│ [Jawaban C]  │ [Jawaban D]  │
└──────────────┴──────────────┘
```

#### **Jawaban Benar** (Wajib)
```
Jawaban Benar *
┌──────────────┐
│ -- Pilih --  │
│ A            │
│ B            │
│ C            │
│ D            │
└──────────────┘
```

#### **Poin** (Opsional)
```
Poin (Opsional)
┌──────────────┐
│ 10           │ (default: 10)
└──────────────┘
```

### Step 3: Isi Semua Field
Contoh:
```
Pertanyaan: Apa itu database?

Opsi A: Koleksi file
Opsi B: Sistem penyimpanan data terstruktur
Opsi C: Aplikasi komputer
Opsi D: Bahasa pemrograman

Jawaban Benar: B
Poin: 15
```

### Step 4: Klik "Simpan Soal"
Button biru di bawah form

### Step 5: Success!
- ✅ Soal tersimpan
- ✅ Redirect ke Bank Soal
- ✅ Soal baru muncul di tabel

---

## ✏️ Mengedit Soal Existing

### Step 1: Di Bank Soal, Klik [Edit]
Di kolom **Aksi**, klik **"Edit"** pada soal yang ingin diubah

### Step 2: Form Preloaded
Semua field sudah terisi dengan data soal sebelumnya

### Step 3: Edit sesuai kebutuhan

### Step 4: Klik "Perbarui"
Button untuk submit perubahan

---

## 🗑️ Menghapus Soal

### Step 1: Di Bank Soal, Klik [Hapus]
Di kolom **Aksi**, klik **"Hapus"** pada soal yang ingin dihapus

### Step 2: Konfirmasi
Browser akan tanya: "Yakin hapus soal ini?"

### Step 3: Klik OK
Soal akan dihapus dari database

---

## 🔄 Workflow Lengkap: Membuat Kuis dari Awal

### 1️⃣ Create Lesson baru
```
Admin → Manajemen Materi & Kuis → [Tambah Baru]
- Title: "Kuis SQL Dasar"
- Module: [Pilih module]
- Type: "kuis"  ← PENTING: Pilih tipe KUIS
- XP Reward: 50
- Content: (opsional)
[Simpan]
```

### 2️⃣ Edit Lesson & Add Soal
```
Admin → Manajemen Materi & Kuis → [Edit] → [📝 Kelola Soal Kuis]
```

### 3️⃣ Tambahkan Soal
```
Bank Soal → [+ Tambah Soal] → Isi form → [Simpan Soal]
```

### 4️⃣ Repeat Step 3
Tambahkan minimal 5-10 soal per kuis

### 5️⃣ Publish/Siap untuk Student
```
Sekarang student bisa:
- Lihat lesson di /courses/{id}/lessons/{id}
- Klik tombol "🎯 Mulai Kuis"
- Kerjakan soal
- Lihat hasil dengan Sweet Alert
```

---

## 📋 Quick Reference

### Admin Quiz URLs

| Purpose | URL | Method |
|---------|-----|--------|
| List Lessons | `/admin/lessons` | GET |
| List Quiz Questions | `/admin/lessons/{lesson}/quiz` | GET |
| Create Question Form | `/admin/lessons/{lesson}/quiz/create` | GET |
| Save Question | `/admin/lessons/{lesson}/quiz` | POST |
| Edit Question Form | `/admin/quiz/{question}/edit` | GET |
| Update Question | `/admin/quiz/{question}` | PUT |
| Delete Question | `/admin/quiz/{question}` | DELETE |

### Important Notes

✅ **Lesson Type HARUS "kuis"** untuk bisa menambah soal
✅ **Minimal 1 soal** harus ada sebelum student bisa akses quiz
✅ **Jawaban harus diisi** semua 4 opsi (A, B, C, D)
✅ **Pilih 1 jawaban benar** saja
✅ **Poin** default 10 jika tidak diisi

---

## ⚠️ Common Issues & Solutions

### ❌ Button "📝 Soal" tidak muncul di lessons list
**Solusi:** Lesson type harus "kuis", bukan "materi"

### ❌ Tidak bisa akses form create soal
**Solusi:** 
1. Pastikan lesson type = "kuis"
2. Pastikan sudah click button "📝 Soal" atau "Kelola Soal Kuis"

### ❌ Form submit tapi tidak tersimpan
**Solusi:**
1. Lihat error messages di atas form (merah)
2. Pastikan SEMUA field wajib sudah diisi
3. Minimal 1 opsi jawaban harus diisi

### ❌ Student tidak bisa akses quiz
**Solusi:**
1. Cek lesson type di admin (harus "kuis")
2. Cek ada minimal 1 soal di Bank Soal
3. Refresh halaman lesson

---

## 🎓 Student Experience

Setelah Anda buat kuis, student bisa:

### Step 1: Buka Lesson
```
http://127.0.0.1:8000/courses/{course_id}/lessons/{lesson_id}
```

### Step 2: Klik "🎯 Mulai Kuis"
Button ungu di halaman lesson

### Step 3: Lihat Quiz Page
```
Bank Soal: Lesson Title

📋 Kerjakan 5 soal di bawah ini. 
Minimal 70% jawaban benar untuk lulus.

[Soal 1] [Radio buttons A-D]
[Soal 2] [Radio buttons A-D]
...
[Soal 5] [Radio buttons A-D]

[Kirim Jawaban] [Batal]
```

### Step 4: Submit & Sweet Alert
- Loading alert muncul
- Hasil ditampilkan dengan Sweet Alert (lulus/gagal)
- XP diberikan jika lulus (hanya 1x)

---

## 📊 Statistics

Setelah student kerjakan quiz:
- Lihat hasil di Admin → User Progress → Lihat User Detail
- Lihat quiz results in `quiz_results` table
- Track XP yang diberikan
- Monitor pass rate

---

## ✅ Checklist

Sebelum publikasi kuis:

- [ ] Lesson type = "kuis"
- [ ] Ada minimal 5 soal
- [ ] Semua soal punya 4 opsi jawaban
- [ ] Semua soal punya jawaban benar yang dipilih
- [ ] Poin sudah set (atau default 10)
- [ ] XP reward sudah set untuk lesson
- [ ] Test buka quiz sebagai student
- [ ] Kerjakan kuis & check hasil
- [ ] Check sweet alert muncul
- [ ] Check XP tersimpan di user

---

## 🎉 Selesai!

Kuis Anda sudah siap untuk student! 🚀

**Pertanyaan?** Lihat:
- Admin Dashboard untuk quick access
- routes/web.php untuk URL structure
- QuestionController untuk logic
- admin/questions/* untuk views

---

**Status:** ✅ PRODUCTION READY
