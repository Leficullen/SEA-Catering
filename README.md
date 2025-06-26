README DOCUMENTATION - SEA Catering

SEA Catering merupakan aplikasi berbasis web yang memungkinkan pengguna untuk berlangganan meal plan dan dapat diantarkan ke banyak kota di Indonesia.
Proyek ini merupakan tugas seleksi untuk mengikuti Software Engineering Academy dalam event COMPFEST-17 yang diadakan oleh mahasiswa fakultas Ilmu Komputer Universitas Indonesia

Fitur Utama Aplikasi:
1. Register and Login
   
   Apabila ada pengguna baru yang membuka website dan langsung memencet halaman subscription, maka pengguna tersebut akan diarahkan (redirect) ke halaman login, karena hanya pengguna yang sudah login yang bisa melakukan langganan. Bagi pengguna yang belum memiliki akun / belum melakukan registrasi, bisa memencet tulisan 'Register' di bawah form password untuk diarahkan ke halaman Registration. Untuk melakukan pendaftaran, pengguna harus membuat password yang terdiri dari minimal 8 karakter, memuat simbol, angka, uppercase, dan lowercase, apabila salah satu
   syarat tidak terpenuhi, maka server akan mengirimkan peringatan dan pengguna diharuskan mengisi ulang form. Pengguna yang telah berhasil registrasi akan langsung diarahkan ke halaman login untuk memasukkan nama dan password yang telah dibuat sebelumnya. Bagi pengguna yang mendaftarkan diri sebagai user, maka akan diarahkan ke user page, sedangkan bagi pengguna yang mendaftar sebagai admin, maka akan diarahkan ke admin page setelah login berhasil. Khusus untuk pengguna yang mendaftarkan sebagai admin wajib mengisi form admin code (27087736).

2. Subscription

   Pada web ini, terdapat subscription page yang berisi form bertipe text, radio, dan checkbox yang berfungsi untuk memasukkan data dari pengguna yang ingin melakukan langganan (hanya pengguna yang sudah login dan memiliki role user yang bisa mengakses page ini, bagi pengguna yang belum login akan langsung diarahkan ke halaman login terlebih dahulu, sedangkan pengguna yang memiliki role admin akan diarahkan ke admin page). Adapun data yang harus dimasukkan oleh pengguna adalah nama lengkap, nomor telepon, alamat, alergi, meal plan, meal type, hari pengantaran, dan gender. Di page subscription ini juga terdapat kolom total price yang berfungsi untuk menampilkan jumlah total harga yang harus dibayarkan konsumen per minggu, adapun mekanisme perhitungan mengikuti formula berikut: harga meal plan yang dipilih * jumlah meal type yang dipilih * jumlah hari yang dipilih. Setelah tombol subscribe ditekan, maka data yang telah dimasukkan user akan langsung dikirm ke database dan terdisplay di halaman user page.

3. User Page

   Pada halaman ini akan menampilkan user dashboard yang berisi data langganan yang telah diisi sebelumnya, bagi pengguna yang belum melakukan langganan apapun, maka dashboard tidak akan ditampilkan dan hanya berisi tulisan pernyataan bahwa pengguna belum memiliki langganan apapun. Di user dashboard juga terdapat box untuk pause subscription yang memungkinkan pengguna untuk menghentikan sementara langganan yang telah dipilih dalam rentang waktu tertentu, selama pause berjalan, maka status langganan akan berganti dari 'active' menjadi 'paused' dan terdapat tombol resume apabila pengguna ingin melanjutkan langganan walaupun masa pause belum berakhir. Di bagian bawah dashboard terdapat tombol cancel subscription yang berfungsi untuk men-cancel langganan yang telah dilakukan sebelumnya.

4. Admin Page

   Pada halaman ini akan menampilakn admin dashboard yang berisi data pelanggan baru, pendapatan bulanan, mantan pelanggan yang berlangganan kembali, dan perkembangan langganan. Untuk memudahkan admin dalam menklasifikasikan data, terdapat filter di bagian atas dashboard yang memungkinkan admin untuk men-filter data berdasarkan rentang periode yang dipilih


Section pada halaman utama:

1. Hero Section

   Dinamakan hero section, karena hero section merupakan view utama yang akan dilihat oleh pengguna ketika mengakses web ini, oleh karena itu section ini berperan seperti "pahlawan" yang harus memberikan kesan pertama yang dapat menarik pengunjung. Pada hero section ini, saya menjadikan motto dari SEA Catering sebagai center dari hero section, di bawah tulisan motto tersebut, terdapat tombol 'subscribe now' yang dapat mengarahkan pengunjung ke subscription page. Latar belakang berupa sayuran dan buah-buahan yang dominan berwarna hijau dipilih agar dapat memberikan kesan segar dan sehat kepada pengunjung, yang sesuai dengan konsep SSEA-Catering.

2. Service List Secion

   Pada section ini, terdapat 3 video yang disusun horizontal yang mewakili tiap service yang disediakan oleh SEA-Catering

3. Menu List Section

   Pada Section ini, menampilkan 3 foto yang merepresentasikan tiap meal plan yang disediakan sea catering, di samping foto tersebut terdapat teks yang berisikan nama dari meal plan, harga, dan deskripsi singkat terkait meal plan tersebut. Di bawah text, terdapat tombol 'see details' yang apabila ditekan, maka akan memunculkan pop up yang berisikan informasi lebih lanjut terkait meal plan tersebut, dan di dalam pop up tersebut juga terdapat tombol subscribe yang apabila ditekan maka akan mengarahkan pengunjung ke halaman subscription.

4. About Us Section

   Pada section ini, berisikan foto dari logo Sea-Catering dan informasi serta sejarah singkat dari SEA-Catering.

5. Contact Us Section

   Pada section ini, berisikan peta lokasi sea-catering (lokasi fasilkom UI) yang terakses langsung ke google maps, kemudian di sampingnya terdapat contact dari manajer SEA-Catering yang bisa langsung dihubungi melalui tombol 'message now', apabila ditekan, maka akan diarahkan ke whatsapp manajer.

6. Testimony Section

   Pada section ini, berisikan form yang meminta user untuk memasukkan nama, beserta testimoni yang ingin diberikan. Data yang telah diisi akan dikirimkan ke database dan langsung terdisplay di bagian bawah testimoni section. Di bagian bawah testimoni section, akan terdisplay nama, testimoni, beserta tanggal testimoni dikirimkan (komentar terbaru akan diletakkan di paling atas)

7. Footer Section

   Footer section merupakan pengakhir dari halaman utama web ini, di dalamnya terdapat logo media sosial yang bisa langsung diakses dengan menekan salah satunya, kemudian di baweahnya terdapat tulisan home, menu, contact us, dan subscription yang bersifat tautan, sehingga apabila diklik, maka akan langsung mengarahkan pengguna ke section atau page yang dimaksud.
   

   
