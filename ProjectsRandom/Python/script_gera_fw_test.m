clc
clear all
close all

% O arquivo IntelHex
A = fileread('fw_extensor_P3_rls_1.0.5_so_dados.hex');
A = regexprep(A,'[\n\r]+','');
A(A == char(10)) = ''; 

% Declara��es
Bytes_por_Comando    = 768 * 2;
Pacotes_Cheios       = fix(length(A)/Bytes_por_Comando);
Bytes_Ultimo_Pacote  = (length(A) - (Pacotes_Cheios * Bytes_por_Comando))/2;
Endereco_Atual       = 0;
Offset               = 1;
CS_Soma              = 0;

% Criando o arquivo do firmware
filename = sprintf("script_fw_extensor_octave.txt");
fid=fopen(filename, 'w');

tela_1 = waitbar(0,'1','Name','Progresso pacotes...',...
    'CreateCancelBtn','setappdata(gcbf,''Botao_Cancela'',1)');
setappdata(tela_1,'Botao_Cancela',0);


% Escrevendo todos os pacotes
for i = 1:Pacotes_Cheios
  C = A( Offset : Bytes_por_Comando + Offset - 1);
  B = ["8C010300"];
  B = [B, sprintf("%08x", Endereco_Atual)];
  B = [B, sprintf("%s", C)]
  fprintf(fid, B);           
  fprintf(fid, "\n\n");       
  Endereco_Atual = Endereco_Atual + 768;
  Offset = Offset + Bytes_por_Comando;
  disp('   ');
  waitbar(i / Pacotes_Cheios,tela_1,sprintf('Pacotes Escritos: %i',i))
  
  if getappdata(tela_1,'Botao_Cancela')
      break
  end
  pause(0.05)
endfor
close(tela_1);

% Escrevendo o �ltimo pacote
C = A(end-Bytes_Ultimo_Pacote*2+1:end);
B = ["8C01"];
B = [B, sprintf("%04x", Bytes_Ultimo_Pacote), sprintf("%08x", Endereco_Atual), sprintf("%s", C)]
fprintf(fid, B);
fprintf(fid, "\n\n");

tela_2 = waitbar(0,'Calculando Checksum...');
% Escrevendo a linha do checksum
for i = 1:2:length(A)
  D = ["0x",sprintf("%s", A(i)) sprintf("%s", A(i+1))];
  D = str2num(D);
  CS_Soma = (CS_Soma + D);  
endfor
waitbar(1,tela_2,'Calculado!');
pause(1)
close(tela_2);

CS_Soma = CS_Soma - fix(CS_Soma/(0xFFFF+1))*(0xFFFF+1);

B = ["8C0200000000"];
B = [B, sprintf("%08x", ((length(A)/2)-1)), sprintf("%04x", CS_Soma)]
fprintf(fid, B);

% Fechando o arquivo e concluindo 
fclose(fid);  
disp('Arquivo Gerado');
