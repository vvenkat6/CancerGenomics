#! /usr/bin/python
import subprocess

rep = subprocess.Popen('Rscript report.Rscript', shell=True)
rep.wait()
rep = subprocess.Popen('pdflatex "\def\myvar{newfile.txt} \input{report_v1.tex}"', shell=True)
rep.wait()
