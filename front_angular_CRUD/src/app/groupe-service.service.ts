import { Injectable } from '@angular/core';

import { HttpClient } from '@angular/common/http';
import { Observable } from 'rxjs';
import { Groupe } from './groupe.model';

@Injectable({
  providedIn: 'root'
})

export class GroupeServiceService {
  private apiUrl = 'http://127.0.0.1:8000';
  constructor(private http: HttpClient) {}

  getGroupes(): Observable<any> {
    return this.http.get('/api/groupe/all');
  }

  updateGroupe(newBand: any, id: number): Observable<any> {
    return this.http.post(`${this.apiUrl}/groupes/update/${id}`, newBand);
  }

  getGroupeById(id: number): Observable<Groupe> {
    return this.http.get<Groupe>(`${this.apiUrl}/groupes/getOne/${id}`);
  }

  deleteGroupe(id: number): Observable<void> {
    return this.http.delete<void>(`${this.apiUrl}/groupes/delete/${id}`);
  }
}
