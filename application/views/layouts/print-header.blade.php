<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <title>{{ $report->title }}</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        
        <style>
          body {
            margin: 0;
            font-family: Arial;
            font-size: 12px;
            color: #333333;
            background-color: #ffffff;
          }

          table {
            max-width: 100%;
            background-color: transparent;
            border-collapse: collapse;
            border-spacing: 0;
          }

          .table {
            width: 100%;
            margin-bottom: 20px;
          }

          .table th,
          .table td {
            padding: 8px;
            line-height: 20px;
            text-align: left;
            vertical-align: top;
            border-top: 1px solid #dddddd;
          }

          .table th {
            font-weight: bold;
          }

          .table thead th {
            vertical-align: bottom;
          }


          .table .table {
            background-color: #ffffff;
          }

          .table-condensed th,
          .table-condensed td {
            padding: 4px 5px;
          }

          .table-bordered {
            border: 1px solid #dddddd;
            border-collapse: separate;
            *border-collapse: collapse;
            border-left: 0;
            -webkit-border-radius: 4px;
               -moz-border-radius: 4px;
                    border-radius: 4px;
          }

          .table-bordered th,
          .table-bordered td {
            border-left: 1px solid #dddddd;
          }

          .table-bordered caption + thead tr:first-child th,
          .table-bordered caption + tbody tr:first-child th,
          .table-bordered caption + tbody tr:first-child td,
          .table-bordered colgroup + thead tr:first-child th,
          .table-bordered colgroup + tbody tr:first-child th,
          .table-bordered colgroup + tbody tr:first-child td,
          .table-bordered thead:first-child tr:first-child th,
          .table-bordered tbody:first-child tr:first-child th,
          .table-bordered tbody:first-child tr:first-child td {
            border-top: 0;
          }

          .table-bordered thead:first-child tr:first-child > th:first-child,
          .table-bordered tbody:first-child tr:first-child > td:first-child,
          .table-bordered tbody:first-child tr:first-child > th:first-child {
            -webkit-border-top-left-radius: 4px;
                    border-top-left-radius: 4px;
            -moz-border-radius-topleft: 4px;
          }

          .table-bordered thead:first-child tr:first-child > th:last-child,
          .table-bordered tbody:first-child tr:first-child > td:last-child,
          .table-bordered tbody:first-child tr:first-child > th:last-child {
            -webkit-border-top-right-radius: 4px;
                    border-top-right-radius: 4px;
            -moz-border-radius-topright: 4px;
          }

          .table-bordered thead:last-child tr:last-child > th:first-child,
          .table-bordered tbody:last-child tr:last-child > td:first-child,
          .table-bordered tbody:last-child tr:last-child > th:first-child,
          .table-bordered tfoot:last-child tr:last-child > td:first-child,
          .table-bordered tfoot:last-child tr:last-child > th:first-child {
            -webkit-border-bottom-left-radius: 4px;
                    border-bottom-left-radius: 4px;
            -moz-border-radius-bottomleft: 4px;
          }

          .table-bordered thead:last-child tr:last-child > th:last-child,
          .table-bordered tbody:last-child tr:last-child > td:last-child,
          .table-bordered tbody:last-child tr:last-child > th:last-child,
          .table-bordered tfoot:last-child tr:last-child > td:last-child,
          .table-bordered tfoot:last-child tr:last-child > th:last-child {
            -webkit-border-bottom-right-radius: 4px;
                    border-bottom-right-radius: 4px;
            -moz-border-radius-bottomright: 4px;
          }

          .table-bordered tfoot + tbody:last-child tr:last-child td:first-child {
            -webkit-border-bottom-left-radius: 0;
                    border-bottom-left-radius: 0;
            -moz-border-radius-bottomleft: 0;
          }

          .table-bordered tfoot + tbody:last-child tr:last-child td:last-child {
            -webkit-border-bottom-right-radius: 0;
                    border-bottom-right-radius: 0;
            -moz-border-radius-bottomright: 0;
          }

          .table-bordered caption + thead tr:first-child th:first-child,
          .table-bordered caption + tbody tr:first-child td:first-child,
          .table-bordered colgroup + thead tr:first-child th:first-child,
          .table-bordered colgroup + tbody tr:first-child td:first-child {
            -webkit-border-top-left-radius: 4px;
                    border-top-left-radius: 4px;
            -moz-border-radius-topleft: 4px;
          }

          .table-bordered caption + thead tr:first-child th:last-child,
          .table-bordered caption + tbody tr:first-child td:last-child,
          .table-bordered colgroup + thead tr:first-child th:last-child,
          .table-bordered colgroup + tbody tr:first-child td:last-child {
            -webkit-border-top-right-radius: 4px;
                    border-top-right-radius: 4px;
            -moz-border-radius-topright: 4px;
          }

          
          .table tbody tr.success > td {
            background-color: #dff0d8;
          }

          .table tbody tr.error > td {
            background-color: #f2dede;
          }

          .table tbody tr.warning > td {
            background-color: #fcf8e3;
          }

          .table tbody tr.info > td {
            background-color: #d9edf7;
          }

          .table tbody tr.group > td {
            background-color: #EAEAEA;
            font-size: 12pt;
            font-weight: bold;
          }

          .label,
          .badge {
            display: inline-block;
            padding: 2px 4px;
            font-size: 11.844px;
            font-weight: bold;
            line-height: 14px;
            color: #ffffff;
            text-shadow: 0 -1px 0 rgba(0, 0, 0, 0.25);
            white-space: nowrap;
            vertical-align: baseline;
            background-color: #999999;
          }

          .label {
            -webkit-border-radius: 3px;
               -moz-border-radius: 3px;
                    border-radius: 3px;
          }

          .badge {
            padding-right: 9px;
            padding-left: 9px;
            -webkit-border-radius: 9px;
               -moz-border-radius: 9px;
                    border-radius: 9px;
          }

          .label:empty,
          .badge:empty {
            display: none;
          }

          a.label:hover,
          a.label:focus,
          a.badge:hover,
          a.badge:focus {
            color: #ffffff;
            text-decoration: none;
            cursor: pointer;
          }

          .label-important,
          .badge-important {
            background-color: #b94a48;
          }

          .label-important[href],
          .badge-important[href] {
            background-color: #953b39;
          }

          .label-warning,
          .badge-warning {
            background-color: #f89406;
          }

          .label-warning[href],
          .badge-warning[href] {
            background-color: #c67605;
          }

          .label-success,
          .badge-success {
            background-color: #468847;
          }

          .label-success[href],
          .badge-success[href] {
            background-color: #356635;
          }

          .label-info,
          .badge-info {
            background-color: #3a87ad;
          }

          .label-info[href],
          .badge-info[href] {
            background-color: #2d6987;
          }

          .label-inverse,
          .badge-inverse {
            background-color: #333333;
          }

          .label-inverse[href],
          .badge-inverse[href] {
            background-color: #1a1a1a;
          }

          .muted {
            color: #999999;  
          }
          


        </style>

        <!-- Le HTML5 shim, for IE6-8 support of HTML5 elements -->
        <!--[if lt IE 9]>

          <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
        <![endif]-->
    </head>
    <body>
      <!-- section content -->
      <section class="section">
          <div class="row-fluid">
            <div class="span12">
              <h1>{{ $report->title }}</h1>
            </div>
          </div>
          <div class="row-fluid">
            <!-- span content -->
            <div class="span12">