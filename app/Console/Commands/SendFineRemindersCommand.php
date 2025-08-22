<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Borrowing;
use Illuminate\Support\Facades\Mail;
use App\Mail\FineReminderMail;

class SendFineRemindersCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'fines:remind';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Mengirim reminder untuk denda yang belum dibayar';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Memulai pengiriman reminder denda...');

        // Ambil semua denda yang belum dibayar
        $unpaidFines = Borrowing::with(['user', 'book'])
            ->where('fine_amount', '>', 0)
            ->where('fine_paid', false)
            ->get();

        $sentCount = 0;
        
        foreach ($unpaidFines as $borrowing) {
            try {
                // Kirim email reminder (jika email tersedia)
                if ($borrowing->user->email) {
                    Mail::to($borrowing->user->email)
                        ->send(new FineReminderMail($borrowing));
                    $sentCount++;
                }
                
                $this->info("Reminder dikirim ke {$borrowing->user->email} untuk denda Rp " . number_format($borrowing->fine_amount, 0, ',', '.'));
                
            } catch (\Exception $e) {
                $this->error("Gagal mengirim reminder ke {$borrowing->user->email}: " . $e->getMessage());
            }
        }

        $this->info("Total {$sentCount} reminder denda berhasil dikirim.");
        $this->info('Pengiriman reminder selesai!');
        
        return Command::SUCCESS;
    }
}
