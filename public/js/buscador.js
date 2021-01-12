
        $(document).ready(function(){
            $('#divcheck').click(function(){
                
                if(document.getElementsByName('EnProceso')[0].checked){                    
                    $('#check2').hide();
                    $('#check3').hide();
                   
                }else{
                    if(document.getElementsByName('Pendiente')[0].checked){
                        $('#check1').hide();
                        $('#check3').hide();
                        
                    }else{
                        if(document.getElementsByName('Finalizado')[0].checked){
                            $('#check1').hide();
                            $('#check2').hide();
                        }else{
                            $('#check1').show();
                            $('#check2').show();
                            $('#check3').show();
                        }
                        
                    }
                }

                if(document.getElementsByName('Requisito(Deseo)')[0].checked){                    
                    $('#check5').hide();
                    $('#check6').hide();
                   
                }else{
                    if(document.getElementsByName('Sinapuro')[0].checked){
                        $('#check4').hide();
                        $('#check6').hide();
                        
                    }else{
                        if(document.getElementsByName('Urgente')[0].checked){
                            $('#check4').hide();
                            $('#check5').hide();
                        }else{
                            $('#check4').show();
                            $('#check5').show();
                            $('#check6').show();
                        }
                        
                    }
                }
                