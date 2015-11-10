#!/usr/bin/env python

import matplotlib
matplotlib.use('Agg')
from matplotlib import pyplot as plt
import seaborn as sns; sns.set(color_codes=True)
import pandas as pd
#sns.set(style="whitegrid", palette="pastel")

test = pd.read_csv('newfile.txt',sep='\t')

hue_ord = list(set(test.Variant_Classification))
plt.figure(figsize=(12,12))
plt.title('Mutation type vs Cosmic Score',size=14)
sns.stripplot(x='Gene',y='Cosmic',hue='Variant_Classification',edgecolor='black',data=test,jitter=True,split=True)
plt.legend(loc='center left', bbox_to_anchor=(1, 0.5))
plt.xticks(rotation=90,size=14)
plt.yticks(size=14)
plt.savefig('resulteshwar')
