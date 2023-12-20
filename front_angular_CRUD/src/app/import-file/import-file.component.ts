import { Component, OnInit } from '@angular/core';
import { HttpClient } from '@angular/common/http';
import { Router } from '@angular/router';


@Component({
  selector: 'app-import-file',
  templateUrl: './import-file.component.html',
  styleUrl: './import-file.component.scss'
})
export class ImportFileComponent implements OnInit{

  constructor(private http: HttpClient, private router: Router) {}

  ngOnInit(): void {}

  selectedFile: File | null = null;
  uploadedFileName: string | null = null;
  showWarning: boolean = false;

  onFileSelected(event: any): void {
    if (event.target.files[0] && this.isXlsxFile(event.target.files[0].name)) {
      this.selectedFile = event.target.files[0];
      this.uploadedFileName = event.target.files[0].name;
      this.showWarning = false;
    } else {
      this.selectedFile = null;
      this.uploadedFileName = null;
      this.showWarning = true;
    }
  }

  uploadFile(): void {
    if (this.selectedFile) {
      const formData = new FormData();
      formData.append('file', this.selectedFile);

      this.http.post('http://127.0.0.1:8000/upload', formData).subscribe(
        (response: any) => {
          console.log('File uploaded successfully', response);
          // Update the uploadedFileName
          this.uploadedFileName = response.filename;
          this.router.navigate(['/bands']);
        },
        (error) => {
          console.error('Error uploading file', error);
        }
      );
    }
  }

  isXlsxFile(fileName: string): boolean {
    return fileName.endsWith('.xlsx');
  }

  navigateToList() {
    this.router.navigate(['/groupes']);
  }
  
}


