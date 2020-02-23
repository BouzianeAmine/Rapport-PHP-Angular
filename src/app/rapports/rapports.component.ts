import { Component, OnInit } from '@angular/core';
import { MatTableDataSource } from '@angular/material/table';
import { Rapport } from '../models/rapport';
import { getCurrentUser, updateSolde } from '../handlers/userSession';
import { User } from '../models/user';
import { UserService } from '../user.service';
import { RapportService } from '../rapport.service';



@Component({
  selector: 'app-rapports',
  templateUrl: './rapports.component.html',
  styleUrls: ['./rapports.component.css']
})
export class RapportsComponent implements OnInit {
  displayedColumns: string[] = ['name', 'filiere', 'sujet', 'data'];
  dataSource: MatTableDataSource<Rapport>;
  rapports: Array<Rapport>;
  constructor(private userService: UserService,private rapportService:RapportService) {
    this.getRapports();
  }

  ngOnInit() { }

  getRapports() {
    this.rapportService.getRapports().subscribe((rapports:Array<Rapport>)=>{
      this.dataSource = new MatTableDataSource(rapports);
    })
  }

  applyFilter(filterValue: string) {
    this.dataSource.filter = filterValue.trim().toLowerCase();
  }

  download() {
    updateSolde(-1).then(user => this.userService.update(user));
  }

  soldeBehave(): boolean {
    var res: boolean = null;
    getCurrentUser().subscribe(user => {
      if (user == null || user.solde == 0) {
        res = false;
      } else res = true;
    })
    return res;
  }
}
