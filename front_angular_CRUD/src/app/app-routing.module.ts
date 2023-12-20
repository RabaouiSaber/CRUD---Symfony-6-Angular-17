import { NgModule } from '@angular/core';
import { RouterModule, Routes } from '@angular/router';
import { ImportFileComponent } from './import-file/import-file.component';
import { EditGroupeComponent } from './edit-groupe/edit-groupe.component';
import { ListGroupeComponent } from './list-groupe/list-groupe.component';


const routes: Routes = [
  { path: '', component: ImportFileComponent },
  { path: 'groupeEdit/:id', component: EditGroupeComponent },
  { path: 'groupes', component: ListGroupeComponent }
];


@NgModule({
  imports: [RouterModule.forRoot(routes)],
  exports: [RouterModule]
})
export class AppRoutingModule { }
