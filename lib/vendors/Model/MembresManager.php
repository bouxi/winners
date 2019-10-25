<?php
namespace Model;

use \OCFram\Manager;
use \Entity\Membre;

abstract class MembresManager extends Manager
{
	/**
	 * Méthode permettant d'ajouter un membre.
	 * @param $membre Le membre à ajouter
	 * @return void
	 */
	abstract protected function add(Membre $membre);

	/**
	 * Méthode permettant de supprimer un membre.
	 * @param $id L'identifiant du membre à supprimer
	 * @return void
	 */
	abstract public function delete($id);

	/**
	 * Méthode permettant d'enregistrer un membre.
	 * @param $membre Le membre à enregistrer
	 * @return void
	 */
	public function save(Membre $membre)
	{
		if ($membre->isValid())
		{
			$membre->isNew() ? $this->add($membre) : $this->modify($membre);
		}
		else
		{
			throw new \RuntimeException('Le membre doit être validé pour être enregistré');
		}
	}

	
	/**
	 * Méthode permettant de récupérer une liste de membre.
	 * @param 
	 * @return void
	 */
	// abstract public function getListMembre();

	/**
	 * Méthode permettant de modifier un membre.
	 * @param $membre Le membre à modifier
	 * @return void
	 */
	abstract protected function modify(Membre $membre);

	/** 
	 * Méthode permettant d'obtenir un membre spécifique.
	 * @param $id L'identifiant du membre
	 * @return Membre
	 */
	abstract public function get($id);
}