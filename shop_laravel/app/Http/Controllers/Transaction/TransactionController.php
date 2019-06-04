<?php
    namespace App\Http\Controllers\Transaction;

    use App\Http\Controllers\Controller;

    use App\Shop\Entity\Transaction;

    use Exception;

    class TransactionController extends Controller{
        public function transactionListPage(){
            $user_id = session()->get('user_id');

            $row_per_page = 10;
            $TransactionPaginate = Transaction::where('user_id', $user_id)
                ->OrderBy('created_at', 'desc')
                ->with('Merchandise') //取得關聯資料
                ->paginate($row_per_page);
                
            foreach($TransactionPaginate as &$Transaction){
                if(!is_null($Transaction->Merchandise->photo)){
                    $Transaction->Merchandise->Photo = url($Transaction->Merchandise->photo);
                }
            }

            $binding = [
                'title' => 'Transaction History',
                'TransactionPaginate' => $TransactionPaginate,
            ];

            return view('transaction.listUserTransaction', $binding);
        }
    }
?>