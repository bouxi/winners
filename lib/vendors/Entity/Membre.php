<?php
namespace Entity;

use \OCFram\Entity;

class Membre extends Entity
{
	protected $pseudo,
			  $pass,
			  $email,
			  $nom,
			  $prenom,
			  $dateNaissance,
			  $dateInscription,
			  $dateDerniereCo;

	const PSEUDO_INVALIDE = 1;
	const PASS_INVALIDE = 2;
	const EMAIL_INVALIDE = 3;
	const NOM_INVALIDE = 4;
	const PRENOM_INVALIDE = 5;

	public function isValid()
	{
		return !(empty($this->pseudo) || empty($this->pass) || empty($this->email));
	}

	// SETTERS // 
	public function setPseudo($pseudo)
	{
		if (!is_string($pseudo) || empty($pseudo))
		{
			$this->erreurs[] = self::PSEUDO_INVALIDE;
		}

		$this->pseudo = $pseudo;
	}


	public function setPass($pass)
	{
		if (!is_string($pass) || empty($pass))
		{
			$this->erreur[] = self::PASS_INVALIDE;
		}

		$this->pass = $pass;
	}

	public function setEmail($email)
	{
		if (!is_string($email) || empty($email))
		{
			$this->erreur[] = self::EMAIL_INVALIDE;
		}

		$this->email = $email;
	}

	public function setNom($nom)
	{
		if (!is_string($nom) || empty($nom))
		{
			$this->erreur[] = self::NOM_INVALIDE;
		}

		$this->nom = $nom;
	}

	public function setPrenom($prenom)
	{
		if (!is_string($prenom) || empty($prenom))
		{
			$this->erreur[] = self::PRENOM_INVALIDE;
		}

		$this->prenom = $prenom;
	}

	public function setDateNaissance(\DateTime $dateNaissance)
	{
		$this->dateNaissance = $dateNaissance;
	}

	public function setDateInscription(\DateTime $dateInscription)
	{
		$this->dateInscription = $dateInscription;
	}

	public function setDateDerniereCo(\DateTime $dateDerniereCo)
	{
		$this->dateDerniereCo = $dateDerniereCo;
	}

	// GETTERS // 

	public function pseudo()
	{
		return $this->pseudo;
	}

	public function pass()
	{
		return $this->pass;
	}

	public function email()
	{
		return $this->email;
	}

	public function nom()
	{
		return $this->nom;
	}

	public function prenom()
	{
		return $this->prenom;
	}

	public function dateNaissance()
	{
		return $this->dateNaissance;
	}

	public function dateInscription()
	{
		return $this->dateInscription;
	}

	public function dateDerniereCo()
	{
		return $this->dateDerniereCo;
	}



}