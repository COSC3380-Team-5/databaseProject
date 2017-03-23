<?php

	namespace App\Controllers;

	use Address;
	use App\Core\App;
	use App\Core\Auth;
	use Role;
	use User;

	class UsersController {
		public function show() {
			$users = User::selectAll();

			return view( 'index' ,
			             compact( 'users' ) );
		}

		public function postOfficeUsers() {
			$user = Auth::user();
			$user->postOfficeId;

			$customers = User::findall()->where(['postOfficeId'],
			                                    ['='],
			                                    [$user->postOfficeId])->get();
			echo 'viktor was here';

			//dd( $customers );

			return view( 'dashboard/customers' ,
			             compact( 'customers' ) );
		}

		public function userDetail( $userId ) {
			$user = User::find()->where(['id'], ['='], [$userId])->get();

			return view('dashboard/userDetail', compact ('user'));


		}

		public function userInfo()
		{
			$user = Auth::user();
			return view('accounts/userInfo', compact ('user'));
		}

		public function store() {

			$password = md5( $_POST[ 'password' ] );

			$duplicateAddress = Address::find()
			                           ->where( [
				                                    'street' ,
				                                    'city' ,
				                                    'stateId' ,
				                                    'zipCode' ,
			                                    ] ,
			                                    [
				                                    '=' ,
				                                    '=' ,
				                                    '=' ,
				                                    '='
			                                    ] ,
			                                    [
				                                    $_POST[ 'address' ] ,
				                                    $_POST[ 'city' ] ,
				                                    $_POST[ 'stateId' ] ,
				                                    $_POST[ 'zipCode' ]
			                                    ] )
			                           ->get();
			if( ! $duplicateAddress ) {
				Address::insert( [
					                 'street'     => $_POST[ 'address' ] ,
					                 'city'       => $_POST[ 'city' ] ,
					                 'stateId'    => $_POST[ 'stateId' ] ,
					                 'zipCode'    => $_POST[ 'zipCode' ] ,
					                 'createdAt'  => date( "Y-m-d H:i:s" ) ,
					                 'modifiedAt' => date( "Y-m-d H:i:s" )
				                 ] );
				$addressId = Address::lastInsertId();
			} else {
				$addressId = $duplicateAddress->id;
			}
			$role = Role::find()
			            ->where( [
				                     'type'
			                     ] ,
			                     [ '=' ] ,
			                     [ 'employee' ] )
			            ->get();

			$userInsert = User::insert( [
				                            'firstName'  => $_POST[ 'firstName' ] ,
				                            'lastName'   => $_POST[ 'lastName' ] ,
				                            'addressId'  => $addressId ,
				                            'email'      => $_POST[ 'email' ] ,
				                            'password'   => $password ,
				                            'roleId'     => $role->id ,
				                            'createdAt'  => date( "Y-m-d H:i:s" ) ,
				                            'modifiedAt' => date( "Y-m-d H:i:s" )
			                            ] );

			if( $userInsert === true ) {
				$user = User::find()
				            ->where( [ 'id' ] ,
				                     [ '=' ] ,
				                     [ User::lastInsertId() ] )
				            ->get();

				$_SESSION[ 'user' ] = serialize( $user );
				var_dump( $_SESSION );

				// redirect( 'dashboard' );
				// return view( 'auth/register' );
			} else {
				switch( $userInsert ) {
					case '23000':
						$errors = array(
							'email' => 'Email already exists.'
						);

						return view( 'auth/register' ,
						             compact( 'errors' ) );
				}
			}

			return redirect( '' );
		}
	}