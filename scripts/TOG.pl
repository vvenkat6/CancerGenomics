#!/usr/bin/perl

#use strict;
use warnings;
use List::MoreUtils qw{ firstidx };

my $file = $ARGV[0];

########### Genes Extracted ####### ############
my ($ARX, $KLHDC8A, $WFIKKN2, $SIGLEC11, $FOXL2, $NRK);

########### Genes thresholds ###################
my $ARXth = 1.375833;
my $KLHDC8Ath = 1.864639;
my $WFIKKN2th = 1.168802;

my $SIGLEC11th = 0.968540;
my $FOXL2th = 1.091049;
my $NRKth = 0.731139;

################################################
my $rank1=0;
my $rank2=0;

open FH, $file or die $!;
my @filerows = <FH>;
close(FH);
foreach my $row (@filerows)
{
chomp($row);
my ($a, $b) = split /\s+/, $row;
if ((index($a, "ARX|") != -1 )&& $b != 0) 
{
    $ARX = log($b)/log(10);
    if($ARX >= $ARXth) { $rank1 = $rank1 + 1; }
} 
if (index($a, "KLHDC8A|") != -1 && $b != 0)
{
    $KLHDC8A = log($b)/log(10);
    if($KLHDC8A >= $KLHDC8Ath) { $rank1 = $rank1 + 1; }
}
if (index($a, "WFIKKN2|") != -1  && $b != 0)
{
    $WFIKKN2 = log($b)/log(10);
    if($WFIKKN2 >= $WFIKKN2th) { $rank1 = $rank1 + 1; }
}
if (index($a, "SIGLEC11|") != -1  && $b != 0)
{
    $SIGLEC11 = log($b)/log(10);
    if($SIGLEC11 >= $SIGLEC11th) { $rank2 = $rank2 + 1; }
}
if (index($a, "FOXL2|") != -1  && $b != 0)
{
    $FOXL2 = log($b)/log(10);
    if($FOXL2 >= $FOXL2th) { $rank2 = $rank2 + 1; }
}
if ($a =~ /^NRK/  && $b != 0)
{
    $NRK = log($b)/log(10);
    if($NRK >= $NRKth) { $rank2 = $rank2 + 1; }
}
}
############################################### DISPLAY RESULT BASED ON RANK #########################################################
if(($rank1 == 3 && $rank2 == 3) || ($rank1 == 3 && $rank2 == 2) ||  ($rank1 == 3 && $rank2 == 1) || ($rank1 == 3 && $rank2 == 0) || ($rank1 == 2 && $rank2 == 3))
{
    print "The Tissue of this sample are MOST LIKELY of Ovarian origin\n";
}
if($rank1 == 2 && $rank2 == 2 || $rank1 == 2 && $rank2 == 1 ||  $rank1 == 2 && $rank2 == 0 || $rank1 == 1 && $rank2 == 3)
{
    print "The Tissue of this sample are LIKELY of Ovarian origin\n";
}
if($rank1 == 1 && $rank2 == 2 || $rank1 == 1 && $rank2 == 1 ||  $rank1 == 1 && $rank2 == 0 || $rank1 == 0 && $rank2 == 3)
{
    print "The Tissue of Origin for this sample is uncertain\n";
}
if($rank1 == 0 && $rank2 == 2 || $rank1 == 0 && $rank2 == 1 ||  $rank1 == 0 && $rank2 == 0)
{
    print "The Tissue of this sample are UNLIKELY of Ovarian origin\n";
}


