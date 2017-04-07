<?php

    namespace App\Controllers;

    use App\Core\Auth;
    use Package;
    use Transaction;
    use PostOffice;
    use User;
    use Address;
    use State;
    use PackageStatus;

    class AdminController {
        public function packages() {
            $user = Auth::user();
            if ($user && $user->roleId == 1) {
                $packages = Package::selectAll();

                foreach( $packages as $package ) {
                    $package->user          = User::find()
                        ->where( [ 'id' ] ,
                            [ '=' ] ,
                            [ $package->userId ] )
                        ->get();
                    $package->destination   = Address::find()
                        ->where( [ 'id' ] ,
                            [ '=' ] ,
                            [ $package->destinationId ] )
                        ->get();
                    $package->destination->state = State::find()
                        ->where( ['id']  ,
                            [ '=' ] ,
                            [ $package->destination->stateId] )
                        ->get();
                    $package->returnAddress = Address::find()
                        ->where( [ 'id' ] ,
                            [ '=' ] ,
                            [ $package->returnAddressId ] )
                        ->get();
                    $package->returnAddress->state = State::find()
                        ->where( ['id']  ,
                            [ '=' ] ,
                            [ $package->returnAddress->stateId] )
                        ->get();
                    $package->status = PackageStatus::find()
                        ->where( ['id']  ,
                            [ '=' ] ,
                            [ $package->packageStatus] )
                        ->get();
                }
                return view( 'admin/adminPackages' , compact( 'packages' ) );
            } else if ($user->roleId == 2) {
                return redirect( 'dashboard' );
            } else if ($user->roleId == 3) {
                return redirect( 'account' );
            }
            return redirect('login');

        }

        public function transactions() {
            $user = Auth::user();
            if ($user && $user->roleId == 1) {
                $transactions = Transaction::selectAll();

                foreach ($transactions as $transaction) {
                    $transaction->postOffice = PostOffice::find()
                        ->where(['id'],
                            ['='],
                            [$transaction->postOfficeId])
                        ->get();
                    $transaction->customer = User::find()
                        ->where(['id'],
                            ['='],
                            [$transaction->customerId])
                        ->get();
                    $transaction->employee = User::find()
                        ->where(['id'],
                            ['='],
                            [$transaction->employeeId])
                        ->get();
                    $transaction->package = Package::find()
                        ->where(['id'],
                            ['='],
                            [$transaction->packageId])
                        ->get();
                }

                return view('admin/adminTransactions', compact('transactions'));
            }  else if ($user->roleId == 2) {
                return redirect( 'dashboard' );
            } else if ($user->roleId == 3) {
                return redirect( 'account' );
            }
            return redirect('login');
        }

        public function postOffices()
        {
            $user = Auth::user();
            if ($user && $user->roleId == 1) {
                $postOffices = PostOffice::selectAll();

                foreach ($postOffices as $postOffice) {
                    $postOffice->state = State::find()
                        ->where(['id'], ['='], [$postOffice->stateId])
                        ->get()->state;
                }

                return view('admin/adminPostOffices', compact('postOffices'));
            }  else if ($user->roleId == 2) {
                return redirect( 'dashboard' );
            } else if ($user->roleId == 3) {
                return redirect( 'account' );
            }
            return redirect('login');
        }

        public function selectedPostOffice($postOfficeId) {
            $user = Auth::user();
            if ($user && $user->roleId == 1) {
                $postOffice = PostOffice::find()
                                        ->where( ['id'], [ '=' ] , [ $postOfficeId ] )
                                        ->get();
                $postOffice->packages = Package::findAll()
                                               ->where( ['postOfficeId'] , [ '=' ] , $postOfficeId )
                                               ->get();
                $postOffice->employees = User::findAll()
                                             ->where(['postOfficeId' , 'roleId'] , [ '=' , '=' ] , [$postOfficeId , 2])
                                             ->get();
                $postOffice->customers = User::findAll()
                                             ->where(['postOfficeId' , 'roleId'] , [ '=' , '=' ] , [$postOfficeId , 3])
                                             ->get();
                $postOffice->transactions = Transaction::findAll()
                                                       ->where(['postOfficeId'] , [ '=' ] , [$postOfficeId])
                                                       ->get();

                return view( 'admin/adminPostOfficeDetail' , compact( 'postOffice' ) );
            }  else if ($user->roleId == 2) {
                return redirect( 'dashboard' );
            } else if ($user->roleId == 3) {
                return redirect( 'account' );
            }
            return redirect('login');
        }

        public function admin() {
            $user = Auth::user();
            if ($user && $user->roleId == 1) {
                $packages = Package::selectAll();

                return view('admin/admin', compact('packages'));
            }  else if ($user->roleId == 2) {
                return redirect( 'dashboard' );
            } else if ($user->roleId == 3) {
                return redirect( 'account' );
            }
            return redirect('login');
        }
}