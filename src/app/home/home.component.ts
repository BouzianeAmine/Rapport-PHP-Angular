import { Component, OnInit } from '@angular/core';
import { Rapport } from '../models/rapport';
import { User } from '../models/user';
import { toString, getCurrentUser } from '../handlers/userSession';
import { UserService } from '../user.service';
import { RapportService } from '../rapport.service';
import { Router } from '@angular/router';

export interface rapportDetails {
  filiere: string,
  annee: string,
  encadrant: string,
  sujet: string,
  societe: string
}

@Component({
  selector: 'app-home',
  templateUrl: './home.component.html',
  styleUrls: ['./home.component.css']
})
export class HomeComponent implements OnInit {
  rapports: Array<Rapport>;
  currentUser: User;
  rapport: rapportDetails;
  formData: FormData;
  constructor(private router: Router, private userSP: UserService, private rapportS: RapportService) {
    getCurrentUser().subscribe(user => { this.currentUser = user });
    this.rapport = { "filiere": "", "annee": "", "encadrant": "", "sujet": "", "societe": "" }
  }

  ngOnInit() {
    getCurrentUser().subscribe(user => {
      this.rapportS.getRapportsUser(user).subscribe(rapports => this.rapports = rapports)
    })
  }

  handleFileInput(event) {
    this.formData = new FormData();
    this.formData.append('file', event.target.files[0]);
    this.formData.append('user', toString(this.currentUser));
  }

  ajouter() {
    this.formData.append('rapportDetails', toString(this.rapport));
    this.rapportS.addRapport(this.formData)
    this.router.navigate(['/rapports']).then(() => window.location.reload());
  }
}
