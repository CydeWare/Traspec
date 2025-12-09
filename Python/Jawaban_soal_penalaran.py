import re
from collections import Counter

artikel = """
Dalam kehidupan suatu negara, pendidikan memegang peranan yang amat
penting untuk menjamin kelangsungan hidup negara dan bangsa, karena pendidikan
merupakan wahana untuk meningkatkan dan mengembangkan kualitas sumber daya
manusia. Seiring dengan perkembangan teknologi komputer dan teknologi informasi,
sekolah-sekolah di Indonesia sudah waktunya mengembangkan Sistem Informasi
manajemennya agar mampu mengikuti perubahan jaman.
SISKO mampu memberikan kemudahan pihak pengelola menjalankan
kegiatannya dan meningkatkan kredibilitas dan akuntabilitas sekolah dimata siswa,
orang tua siswa, dan masyakat umumnya.Penerapan teknologi informasi untuk
menunjang proses pendidikan telah menjadi kebutuhan bagi lembaga pendidikan di
Indonesia. Pemanfaatan teknologi informasi ini sangat dibutuhkan untuk
meningkatkan efisiensi dan produktivitas bagi manajemen pendidikan. Keberhasilan
dalam peningkatan efisiensi dan produktivitas bagi manajemen pendidikan akan ikut
menentukan kelangsungan hidup lembaga pendidikan itu sendiri. Dengan kata lain
menunda penerapan teknologi informasi dalam lembaga pendidikan berarti menunda
kelancaran pendidikan dalam menghadapi persaingan global.
Pemanfaatan teknologi informasi diperuntukkan bagi peningkatan kinerja
lembaga pendidikan dalam upayanya meningkatkan kualitas Sumber Daya Manusia
Indonesia. Guru dan pengurus sekolah tidak lagi disibukkan oleh pekerjaan-pekerjaan
operasional, yang sesungguhnya dapat digantikan oleh komputer. Dengan demikian
dapat memberikan keuntungan dalam efisien waktu dan tenaga.
Penghematan waktu dan kecepatan penyajian informasi akibat penerapan
teknologi informasi tersebut akan memberikan kesempatan kepada guru dan pengurus
sekolah untuk meningkatkan kualitas komunikasi dan pembinaan kepada siswa.
Dengan demikian siswa akan merasa lebih dimanusiakan dalam upaya
mengembangkan kepribadian dan pengetahuannya.
Sebagai contoh yang paling utama adalah sistem penjadwalan yang harus
dilakukan setiap awal semester. Biasanya membutuhkan waktu lama untuk menyusun
penjadwalan, Dengan SISKO dapat selesai dalam waktu singkat. Untuk
mempermudah bagian administrasi kurikulum sekolah, SISKO menyediakan fasilitas
istimewa yang merupakan inti dari sistem kurikulum sekolah yaitu membantu dalam
pembuatan penjadwalan mata pelajaran sekolah yang dapat diproses tidak lebih lama
dari 10 menit. Administrator hanya akan memasukkan kondisi dari masing-masing
guru yang akan mengajar baik itu dalam 1 minggu seorang guru dapat mengajar berapa
jam, selain itu dapat juga melakukan pemesanan tempat dan penempatan hari libur
masing-masing guru dalam 1 minggu masa mengajar. Setelah semua kondisi
dimasukkan, sistem akan memproses semua data tersebut sehingga menghasilkan
jadwal yang optimal dan dapat langsung dipakai karena sistem akan mendeteksi
sehingga tidak akan ada jadwal yang bertumpukan satu dengan yang lainnya.
Setelah semua kondisi dimasukkan, sistem akan memproses semua data
tersebut sehingga menghasilkan jadwal yang optimal dan dapat langsung dipakai
karena sistem akan mendeteksi sehingga tidak akan ada jadwal yang bertumpukan satu
dengan yang lainnya. Setelah permasalahan penjadwalan dapat ditangani dengan baik,
hal yang tidak kalah pentingnya adalah memasukkan data siswa.
Program SISKO telah menyediakan fasilitas untuk penanganan penilaian
siswa yang secara langsung memasukkan nilai ke dalam raport dan siap dicetak. Untuk
sistem penilaian siswa, yang dapat melakukan pengisian hanya Guru yang mengajar
mata pelajaran. Sistem penilaian telah disesuaikan dengan KBK sehingga masingmasing guru dapat memasukkan deskripsi narasi dari mata pelajaran. Untuk
menampilkan data penilaian dapat disesuaikan kembali dengan kebijaksanaan dari
masing-masing lembaga pendidikan apakah ingin menampilkan data nilai akhir siswa
maupun menampilkan data nilai siswa setiap kali mengadakan test ataupun tugas
tertentu.
Selain Modul untuk penjadwalan dan Modul Penilaian siswa, SISKO juga
memberikan fasilitas untuk bagian administrasi keuangan sekolah dalam hal
pembayaran SPP siswa. Bagian administrasi dapat langsung mengecek siapa siswa
yang mempunyai tunggakan SPP dan untuk detail histori pembayaran SPP dari
masing-masing siswa dapat dicetak seperti mencetak buku tabungan di bank sehingga
mempermudah pekerjaan pihak administrasi keuangan. Administrasi keuangan dapat
langsung melakukan pengaturan data pembayaran masing-masing siswa sesuai
dengan kebutuhan dan dapat diubah sewaktu-waktu apabila ada kenaikan pembayaran SPP. Apabila siswa tersebut akan melakukan pembayaran, petugas dapat langsung
memasukkan data. Hal sama juga dapat dilakukan untuk Data pembayaran
Sumbangan Sukarela dan Tabungan Karyawisata.
"""

def cari_kata(teks, kata_cari):
    """
    Fungsi a: Pencarian kata dan menghitung kemunculannya
    """

    teks_lower = teks.lower()
    kata_lower = kata_cari.lower()
    

    pattern = r'\b' + re.escape(kata_lower) + r'\b'
    jumlah = len(re.findall(pattern, teks_lower))
    
    print(f"\n{'='*60}")
    print(f"HASIL PENCARIAN KATA: '{kata_cari}'")
    print(f"{'='*60}")
    print(f"Kata '{kata_cari}' ditemukan sebanyak: {jumlah} kali")
    print(f"{'='*60}\n")
    
    return jumlah

def ganti_kata(teks, kata_lama, kata_baru):
    """
    Fungsi b: Penggantian kata (Replace)
    """
   
    pattern = r'\b' + re.escape(kata_lama) + r'\b'
    teks_baru = re.sub(pattern, kata_baru, teks, flags=re.IGNORECASE)
    
    print(f"\n{'='*60}")
    print(f"HASIL PENGGANTIAN KATA")
    print(f"{'='*60}")
    print(f"Kata '{kata_lama}' telah diganti dengan '{kata_baru}'")
    print(f"\nArtikel setelah penggantian:")
    print(f"{'-'*60}")
    print(teks_baru)
    print(f"{'='*60}\n")
    
    return teks_baru

def urutkan_kata(teks):
    """
    Fungsi c: Pengurutan kata berdasarkan abjad
    """
    
    kata_list = re.findall(r'\b[a-zA-Z]+\b', teks.lower())
    
 
    kata_unik = sorted(set(kata_list))
    
    print(f"\n{'='*60}")
    print(f"DAFTAR KATA TERURUT (A-Z)")
    print(f"{'='*60}")
    print(f"Total kata unik: {len(kata_unik)}\n")
    

    for i in range(0, len(kata_unik), 5):
        print(", ".join(kata_unik[i:i+5]))
    
    print(f"\n{'='*60}\n")
    
    return kata_unik


def main():
    while True:
        print("\n" + "="*60)
        print("PROGRAM ANALISIS ARTIKEL SISKO")
        print("="*60)
        print("1. Pencarian Kata")
        print("2. Penggantian Kata")
        print("3. Pengurutan Kata (A-Z)")
        print("4. Jalankan Semua Fungsi")
        print("5. Keluar")
        print("="*60)
        
        pilihan = input("Pilih menu (1-5): ")
        
        if pilihan == "1":
            kata = input("Masukkan kata yang ingin dicari: ")
            cari_kata(artikel, kata)
            
        elif pilihan == "2":
            kata_lama = input("Masukkan kata yang ingin diganti: ")
            kata_baru = input("Masukkan kata pengganti: ")
            ganti_kata(artikel, kata_lama, kata_baru)
            
        elif pilihan == "3":
            urutkan_kata(artikel)
            
        elif pilihan == "4":
            print("\n*** MENJALANKAN SEMUA FUNGSI ***\n")
       
            cari_kata(artikel, "pendidikan")
            input("Tekan Enter untuk lanjut...")
            

            ganti_kata(artikel, "adalah", "ialah")
            input("Tekan Enter untuk lanjut...")
            
           
            urutkan_kata(artikel)
            
        elif pilihan == "5":
            print("\nTerima kasih! Program selesai.")
            break
            
        else:
            print("\nPilihan tidak valid! Silakan pilih 1-5.")

if __name__ == "__main__":
    main()