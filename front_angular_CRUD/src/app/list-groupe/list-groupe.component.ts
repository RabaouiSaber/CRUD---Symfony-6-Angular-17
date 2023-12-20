import { Component, OnInit } from '@angular/core';
import { HttpClient } from '@angular/common/http';
import { Router } from '@angular/router';
import { GroupeServiceService } from '../groupe-service.service';


@Component({
  selector: 'app-list-groupe',
  templateUrl: './list-groupe.component.html',
  styleUrl: './list-groupe.component.scss'
})


export class ListGroupeComponent implements OnInit {
  groupes: any[] = [];

  constructor(
    private http: HttpClient,
    private router: Router,
    private groupeService: GroupeServiceService
  ) {}

  ngOnInit(): void {
    this.loadGroupes();
  }


  loadGroupes(): void {
    this.http.get<any[]>('http://127.0.0.1:8000/groupes/all').subscribe(
      (response) => {
        this.groupes = response;
      },
      (error) => {
        console.error('Error loading groupes', error);
        if (error.status === 0) {
          console.error(
            'Connection error. Make sure your backend server is running.'
          );
        }
      }
    );
  }


  editGroupe(groupeId: number) {
    console.log('ok ok');
    this.router.navigate(['/groupeEdit', groupeId]);
  }


  deleteGroupe(id: number): void {
    if (confirm('Voulez-vous vraiment supprimer ce groupe ?')) {
      this.groupeService.deleteGroupe(id).subscribe(() => {
        this.groupes = this.groupes.filter((groupe) => groupe.id !== id);
      });
    }
  }
  navigateToUpload() {
    this.router.navigate(['/']);
  }
}

