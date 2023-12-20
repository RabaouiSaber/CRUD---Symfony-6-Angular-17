import { Component, OnInit } from '@angular/core';
import { ActivatedRoute, Router } from '@angular/router';
import { Groupe } from '../groupe.model';
import { GroupeServiceService } from '../groupe-service.service';


@Component({
  selector: 'app-edit-groupe',
  templateUrl: './edit-groupe.component.html',
  styleUrl: './edit-groupe.component.scss'
})


export class EditGroupeComponent implements OnInit {
  groupeId = 0;
  groupeData: Groupe = {
    id: 0,
    nomGroupe: '',
    origine: '',
    ville: '',
    anneeDebut: 0,
    anneeSeparation: 0,
    fondateurs: '',
    membres: 0,
    courantMusical: '',
    presentation: '',
  };
  showWarningDeb: boolean = false;
  showWarningSep: boolean = false;
  showWarningSubmit: boolean = false;
  validDeb: boolean = true;
  validSep: boolean = true;
  now = new Date();

  constructor(
    private route: ActivatedRoute,
    private router: Router,
    private groupeService: GroupeServiceService
  ) {}

  ngOnInit(): void {
    this.groupeId = +this.route.snapshot.paramMap.get('id')!;
    this.loadGroupeData();
  }

  private loadGroupeData() {
    this.groupeService.getGroupeById(this.groupeId).subscribe(
      (data) => {
        // Store the retrieved data in the property
        this.groupeData = data;
      },
      (error) => {
        console.error('Error fetching groupe data:', error);
      }
    );
  }

  onSubmit() {

    if (this.groupeData.anneeDebut > this.now.getFullYear()) {
      this.showWarningDeb = true;
      this.validDeb = false;
    } else {
      this.showWarningDeb = false;
      this.validDeb = true;
    }
    if (this.groupeData.anneeSeparation > this.now.getFullYear()) {
      this.showWarningSep = true;
      this.validSep = false;
    } else {
      this.showWarningSep = false;
      this.validSep = true;
    }

    if (this.validDeb && this.validSep) {
      this.groupeService.updateGroupe(this.groupeData, this.groupeId).subscribe(() => {
        this.router.navigate(['/groupes']);
      });
      this.showWarningSubmit = false;
    } else {
      this.showWarningSubmit = true;
    }
  }
  cancel() {
    this.router.navigate(['/groupes']);
  }
}

