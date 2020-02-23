export class Rapport {
  id: number;
  name: string;
  type: string;
  data: string;
  email: string;
  filiere: string;
  annee: string;
  encadrant: string;
  sujet: string;
  societe: string;
  constructor(name, type, filiere: string,
    annee: string,
    encadrant: string,
    sujet: string,
    societe: string) {
    this.name = name;
    this.type = type;
    this.data = null;
    this.filiere=filiere;
    this.annee=annee;
    this.encadrant=encadrant;
    this.sujet=sujet;
    this.societe=societe;
  }


}