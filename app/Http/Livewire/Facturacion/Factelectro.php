<?php

namespace App\Http\Livewire\Facturacion;

use Livewire\Component;

class Factelectro extends Component
{
   // Genera la consulta para obtener el XML
   public function generaxml()
   {
      $InvoiceAuthorization=18760000001;
      $StartDate='2020'; //Fecha de autorización dela resolución
      $EndDate='2020'; // FEcha fin auto
      $Prefix='SEYD'; // Prefijo
      $From=990000000; //Desde dondela numeración
      $To=995000000; // Hasta
      $nitEmpresa=900474371; // Nit Seyd.
      $SoftwareID='56f2ae4e-9812-4fad-9255-08fcfcd5ccb0';
      $pin=12345; // Estos dos se obtienen de registrarklo en la DIAN
      $SoftwareSecurityCode=''; // Ver como se obtiene parte 3.
      $AuthorizationProviderID='800197268'; // NIT DIAN
      $QRCode='NroFactura=SETP990000002
      NitFacturador=800197268
      NitAdquiriente=900108281
      FechaFactura=2019-06-20
      ValorTotalFactura=14024.07
      CUFE=941cf36af62dbbc06f105d2a80e9bfe683a90e84960eae4d351cc3afbe8f848c26c39bac4fbc80fa254824c6369ea694
      URL=https://catalogo-vpfe-hab.dian.gov.co/Document/FindDocument?documentKey=941cf36af62dbbc06f105d2a80e9bfe683a90e84960eae4d351cc3afbe8f848c26c39bac4fbc80fa254824c6369ea694&amp;partitionKey=co|06|94&amp;emissionDate=20190620';

      $CustomizationID = '10'; // SE ASUME QUE ES 10 según lo descrito en video 4
      $ProfileExecutionID= '2'; // 1 produccion 2 pruebas.
      $ID=$Prefix.'990000001'; // Consecutivo de la factura
      $UUID= hash('sha384', ''); // Ver video 5 para obtener
      $IssueDate='2020-10-24'; // FEcha factura en este formato
      $IssueTime ='09:15:23-05:00'; // Hora con este modelo




   }

   public function render()
   {
      return view('livewire.facturacion.factelectro');
   }
}
