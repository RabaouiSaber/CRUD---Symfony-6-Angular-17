

import { NgModule } from '@angular/core';

import { BrowserModule, provideClientHydration } from '@angular/platform-browser';


import { HttpClientModule } from '@angular/common/http';

import { AppRoutingModule } from './app-routing.module';
import { AppComponent } from './app.component';
import { ImportFileComponent } from './import-file/import-file.component';
import { AddGroupeComponent } from './add-groupe/add-groupe.component';
import { EditGroupeComponent } from './edit-groupe/edit-groupe.component';
import { ViewGroupeComponent } from './view-groupe/view-groupe.component';
import { ListGroupeComponent } from './list-groupe/list-groupe.component';

import { FormsModule } from '@angular/forms';

@NgModule({
  declarations: [
    AppComponent,
    ImportFileComponent,
    AddGroupeComponent,
    EditGroupeComponent,
    ViewGroupeComponent,
    ListGroupeComponent
  ],
  imports: [
    BrowserModule,
    AppRoutingModule,
    HttpClientModule,
    FormsModule
  ],
  providers: [
    provideClientHydration()
  ],
  bootstrap: [AppComponent]
})
export class AppModule { }
