<?php
namespace Model;

use \Entity\Membre;

class MembresManagerPDO extends MembresManager
{
	protected function add(Membre $membre)
	{
		$q = $this->dao->prepare('INSERT INTO membres SET pseudo = :pseudo, pass = :pass, email = :email, dateInscription = NOW(), dateDerniereCo = NOW()');

		$q->bindValue(':pseudo', $membre->pseudo());
		$q->bindValue(':pass', $membre->pass());
		$q->bindValue(':email', $membre->email());

		$q->execute();

		$membre->setId($this->dao->lastInsertId());
	}

	public function count()
	{
		return $this->dao->query('SELECT COUNT(*) FROM membres')->fetchColumn();
	}

	public function delete($id)
	{
		$this->dao->exec('DELETE FROM membres WHERE id = '.(int) $id);
	}

	public function getList($debut = -1, $limite = -1)
	{
		$sql = 'SELECT id, pseudo, email, nom, prenom, dateNaissance, dateInscription, dateDerniereCo FROM membres ORDER BY id DESC';

		if ($debut != -1 || $limite != -1)
		{
			$sql .= ' LIMIT '.(int) $limite.' OFFSET '.(int) $debut;
		}

		$requete = $this->dao->query($sql);
		$requete->setFetchMode(\PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE, '\Entity\Membre');

		$listeMembre = $requete->fetchAll();

		foreach ($listeMembre as $membre)
		{
			$membre->setDateNaissance(new \DateTime($membre->dateNaissance()));
			$membre->setDateInscription(new \DateTime($membre->dateInscription()));
			$membre->setDateDerniereCo(new \DateTime($membre->dateDerniereCo()));
		}

		$requete->closeCursor();

		return $listeMembre;
	}

	public function get($id)
	{
		$requete = $this->dao->prepare('SELECT id, pseudo, email, nom, prenom, dateNaissance, dateInscription, dateDerniereCo FROM membres WHERE id = :id');
		$requete->bindValue(':id', (int) $id, \PDO::PARAM_INT);
		$requete->execute();

		$requete->setFetchMode(\PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE, '\Entity\Membre');

		if ($membre = $requete->fetch())
		{
			$membre->setDateNaissance(new \DateTime($membre->dateNaissance()));
			$membre->setDateInscription(new \DateTime($membre->dateInscription()));
			$membre->setDateDerniereCo(new \DateTime($membre->dateDerniereCo()));

			return $membre;
		}

		return null;
	}

	protected function modify(Membre $membre)
	{
		$requete = $this->dao->prepare('UPDATE membres SET pseudo = :pseudo, email = :email, nom = :nom, prenom = :prenom, dateNaissance = :dateNaissance WHERE id = :id');

		$requete->bindValue(':pseudo', $membre->pseudo());
		$requete->bindValue(':email', $membre->email());
		$requete->bindValue(':nom', $membre->nom());
		$requete->bindValue(':prenom', $membre->prenom());
		$requete->bindValue(':dateNaissance', $membre->dateNaissance());
		$requete->bindValue(':id', $membre->id(), \PDO::PARAM_INT);

		$requete->execute();
	}
}