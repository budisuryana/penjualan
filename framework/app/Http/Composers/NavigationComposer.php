<?php namespace App\Http\Composers;



use Illuminate\Contracts\View\View;

use Sentinel;



class NavigationComposer

{



	public function __construct()

	{

		$this->userDet= Sentinel::check();

	}



	public function compose(View $view)

	{

		$userMenu=[];

		$usrLogIn = $this->userDet;

        if($usrLogIn) {

        	$grpId= $usrLogIn->getRoles()[0]->id;

			$userMenu = \App\Models\Role::with(array(

				'appMenu' => function($qApp) use($grpId) {

					$qApp->mainMenu();

					$qApp->whereIsActive('Y');

					$qApp->with( array(

						'childs' => function($qChild) use($grpId) {

							$qChild->join('appmenu_role','appmenu_role.appmenu_id','=','appmenu.menu_id');

							$qChild->Ismenu();

							$qChild->whereIsActive('Y');

							$qChild->whereRoleId($grpId);

							$qChild->with( array(

								'childs' => function($qChild2) use($grpId) {

									$qChild2->join('appmenu_role','appmenu_role.appmenu_id','=','appmenu.menu_id');

									$qChild2->Ismenu();

									$qChild2->whereIsActive('Y');

									$qChild2->whereRoleId($grpId);

									$qChild2->with( array(

										'childs' => function($qChild3) use($grpId) {

											$qChild3->join('appmenu_role','appmenu_role.appmenu_id','=','appmenu.menu_id');

											$qChild3->Ismenu();

											$qChild3->whereIsActive('Y');

											$qChild3->whereRoleId($grpId);

										}) 

									);

								}) 

							);

						}) 

					);

				}

			))

			->whereId($grpId)

			->get();

		}

		

		$view->with('menus', $userMenu);

	}

}