// カード情報を保持するグローバル変数
const cardData = [
  {
    id: 0,
    name: "The Fool",
    img: "./img/0_The fool.jpg",
    meaning: "愚者(ぐしゃ)",
    keyword: "自由・可能性・楽天的・自分勝手",
    description1:
      "【愚者】は、思いのまま自由に生きる姿を表すカード。人の目を気にせず、自分の気持ちに素直に行動することで、大きな可能性が広がるよ。あなたの自由な発想を大切に行動してみて！思ってもみなかったチャンスが舞い込んでくるかも？",
    description2:
      "楽しい恋愛があなたを待っている予感を表す【愚者】のカード。あなたから一歩踏み出すことで、相手と自然体で過ごせるような関係性を築くことができるよ。でもあなたのわがままな一面が表れやすい時期でもあるから、相手の気持ちをくみ取りながらの行動を意識することを忘れないでね！",
  },
  {
    id: 1,
    name: "The Magician",
    img: "./img/1_The Magus.jpg",
    meaning: "魔術師(まじゅつし)",
    keyword: "コミュニケーション・自己実現・集中力・成功",
    description1:
      "【魔術師】のカードは、何事も上手く行く流れです。今日のあなたはどこでも活躍できそう！新しい知識を身に付けてアップグレードしていけるでしょう。自分の能力を信じて行動してみてね。",
    description2:
      "【魔術師】のカードが出た今日は、恋愛における第一歩を踏み出せる予感。好きな人にあなたから話しかけてみて！何気ない話題などで話をつなげていくのがポイント。ただし、しゃべり過ぎにはご注意を！",
  },
  {
    id: 2,
    name: "The Priestess",
    img: "./img/2_The Priestess.jpg",
    meaning: "女祭司(じょさいし)",
    keyword: "感受性、純粋、冷静さ、直観力",
    description1:
      "高い知性と冷静さを表す【女祭司】のカード。このカードが出た今のあなたは、真実を見抜く力にたけているでしょう。直観がよく当たるので、とりあえずピンときたことがあれば実行あるのみ！すぐに役立つかどうかよりも、あなた自身にしっくりくるかどうかをよ～く考えてみてね。",
    description2:
      "【女祭司】のカードは落ち着いた恋愛を意味します。気になるあの子とお互いに落ち着いた関係を育めそうな予感。相手はあなたのことを性格の良い子だと思っていて、好感を持っているはず！関係を進展させたいなら、思い切ってあなたから動いてみよう。",
  },
  {
    id: 3,
    name: "The Empress",
    img: "./img/3_The Empress.jpg",
    meaning: "女帝(じょてい)",
    keyword: "母性愛・愛・幸福",
    description1:
      "【女帝】のカードは、愛情や実りを表します。今日は不安がなく、リラックスした環境で自分の力を発揮できそう。広いココロを持ち相手の意見に耳を傾けてみて。価値観が広がり、いろいろな人と良い関係を築くことができますよ。",
    description2:
      "【女帝】のカードが出たら、愛情たっぷりの関係が期待できるでしょう。あなたの愛が相手に受けとってもらえるかも！相手の気持ちもくみ取りながらの行動を意識してみてね。",
  },
  {
    id: 4,
    name: "The Emperor",
    img: "./img/4_The Emperor.jpg",
    meaning: "皇帝(こうてい)",
    keyword: "大胆な行動・責任",
    description1:
      "【皇帝】は積極性や統率力を意味するカード。前向きな気持ちと積極性があれば目的達成に近づきそう！リーダーシップを発揮して周囲をまとめることも楽しんじゃいましょう。",
    description2:
      "【皇帝】カードが出ました、これは「堂々と行動すること」がキーワード。「自分の気持ちを伝える」とか、「告白してみる」とか、そんな大胆な行動が恋の成就につながるかも。ぜひ積極的に動いてみてね。",
  },
  {
    id: 5,
    name: "The Hierophant",
    img: "./img/5_The Hierophant.jpg",
    meaning: "神官(しんかん)",
    keyword: "包容力、受け入れる心の広さ、落ち着き",
    description1:
      "【神官】のカードを引いた今日は人とのコミュニケーションが鍵となる一日。落ち着いて人の話を聞くようにして、他人の意見に耳を傾けましょう。苦手なあの子の話にも、あなたの役に立つような情報が入っているかも・・・",
    description2:
      "【神官】カードは深く穏やかな恋愛関係に進展する暗示。相手は温かい目であなたを見ており、あなたのことを信頼している様子。でも、好意はあるものの、まだ恋愛感情には至っていない可能性も。あなたの好意をアピールすると関係が進むかも・・・？",
  },
  {
    id: 6,
    name: "The Lovers",
    img: "./img/6_The Lovers.jpg",
    meaning: "恋人(こいびと)",
    keyword: "恋愛・分析・直観",
    description1:
      "【恋人】のカードはワクワクするような楽しい出来事で心が満たされることを表しています。理想の人と出会えたり、好きな人との関係が進展するかも！今日は今まで沈んでいた気持ちが持ち上がるくらい、良い知らせを受け取れる予感。",
    description2:
      "【恋人】のカードは恋愛で幸せを感じられることを暗示しています。今まで沈んでいた気持ちが持ち上がるくらい、恋愛に関する良い知らせを受け取れるでしょう。理想の人と出会えたり、好きな人との関係が進展するかも！見つけたらあなたからアタックしてみて♡",
  },
  {
    id: 7,
    name: "The Chariot",
    img: "./img/7_The Chariot.jpg",
    meaning: "戦車(せんしゃ)",
    keyword: "飛躍、ハイパワー、挑戦する、積極的に動く",
    description1:
      "【戦車】のカードは思い描いたこと、夢や理想に向かっていよいよ行動に移すときがきたことを教えてくれています。今日は重要な日なのかも。自信を持って、積極的に動くことで幸運を手にできそう。",
    description2:
      "【戦車】のカードは短期的に燃え上がる恋愛を意味します。片思いの人は、あまりいろいろ考えずに接していくことでライバルに負けず良い方向へと流れを作っていけるでしょう。アドバイスは「諦めないこと」！！！ ",
  },
  {
    id: 8,
    name: "Adjustment",
    img: "./img/8_Adjustment.jpg",
    meaning: "調整(ちょうせい)",
    keyword: "法則、規律、公平、バランス、ただ見守ること",
    description1:
      "【調整】のカードは自分の勢いを抑えて、控えめに行動することが大切だと示しています。今日は、自分ができる正しい行いを心がけましょう。落ちているゴミを拾う。とか、お父さん、お母さんのお手伝いをする。など。そうすれば良い事はいつか必ず自分へ戻ってきますよ。",
    description2:
      "【調整】のカードは、「バランス、裁き、ただ見守ること」などを示しています。変化することこそが安定につながる。さぁ、あなたからアクションを起こすとき！お互いの時間や距離を考えて行動するのがおススメ！",
  },
  {
    id: 9,
    name: "The Hermit",
    img: "./img/9_The Hermit.jpg",
    meaning: "隠者(いんじゃ)",
    keyword: "孤独、精神的自由、癒し",
    description1:
      "【隠者】は、自らの内面と向き合うことを表すカードです。落ち着いて今の状況を見つめ直すことや、自分自身について考えてみよう。そこから本当の答えが見つかるかも。",
    description2:
      "自分自身と向き合うことの大切さを教えてくれる【隠者】のカード。お互いのことをよく知り、慎重に恋愛を進めていていくことができれば信頼関係が育まれそう。まずはあなたが、これから相手とどういう関係になっていきたいか、自分の気持ちを整理してみて。",
  },
  {
    id: 10,
    name: "Fortune",
    img: "./img/10_Fortune.jpg",
    meaning: "運命(うんめい)",
    keyword: "流れに身を任せる、幸運、チャンス到来",
    description1:
      "【運命】は、逆らうことのできない宿命を表すカードです。期待していなかったチャンスが舞い込み、想像以上に物事がスムーズに進んでいくかも。いままで行き詰まっていたことが解決する予感！",
    description2:
      "【運命】のカードは近い将来チャンスが到来しそうという暗示。「図書室で同じ本を取ろうとする」「曲がり角でぶつかる」といった、ドラマのような出会いが？！それを掴めるかどうかはあなた次第。アンテナを張ってチャンスを逃さないようにしましょう！",
  },
  {
    id: 11,
    name: "Last",
    img: "./img/11_Lust.jpg",
    meaning: "欲望(よくぼう)",
    keyword: "欲望、本能、生命力 、情熱、力の発揮",
    description1:
      "【欲望】のカードは「自分の気持ちに素直になること」を意味します。必要なものではなく、自分の欲しいものを買ったら、うまくいった。そんなことがあるかも。自分の喜ぶことにエネルギーを使いましょう。",
    description2:
      "【欲望】のカードは、心から欲しいものを望むことでそれが手に入ることを意味します。目標を定めてまっすぐ突き進むといいでしょう。まわりの声に耳を傾けすぎないで、あなたの心の声を聞いてみて。気になるあの子との進展があるかも・・・",
  },
  {
    id: 12,
    name: "The Hanged Man",
    img: "./img/12_The Hanged Man.jpg",
    meaning: "吊るされた男",
    keyword: "犠牲、手放す、我慢、洗礼",
    description1:
      "【吊るされた男】は、身動きが取れない状態を表すカードです。今日は整理整頓してみるといいかも。「何かを捨てることは悪い事」というマイナスではなく何かを得るための行為だと思ってみて。もしかしたら、いい結果につながるのかもしれない。",
    description2:
      "【吊るされた男】は、「困難な状況であっても現実を受け入れて忍耐強く努力すれば乗り越えられる」というメッセージです。相手への理解を深めようとする努力が空回りしちゃうかも。自分の視点を少し変えて、相手の立場や感情を考慮してみてね！",
  },
  {
    id: 13,
    name: "The Death",
    img: "./img/13_Death.jpg",
    meaning: "死神(しにがみ)",
    keyword: "生と死、変化、終わりと始まり、再生",
    description1:
      "【死神】は、文字通り「死」を表すわけではなく、大きな変革や新たな始まりを示すカードです。何かを終わらすことで新たなスタートが切られるタイミング。今日はあなたにとって大きな変化が起こるかも？",
    description2:
      "【死神】のカードは、「終わりと始まり」や「方向転換」を表します。2人の関係性に変化がありそう。今まで仲が良かった相手でも、お互いに気持ちがすれ違うような出来事が・・・変化を受け入れることで今より明るい未来が訪れるよ！",
  },
  {
    id: 14,
    name: "Art",
    img: "./img/14_Art.jpg",
    meaning: "技(わざ)",
    keyword: "分解と統合、実現、変化",
    description1:
      "【技】のカードは「変化を起こす」という意味を持ちます。オープンに心を開き、周りから影響を受けることに対して前向きでいよう！聞く耳を持つだけでなく、適度に自分の言葉で語ることもできるはず。",
    description2:
      "【技】のカードは、穏やかで順調に進む恋愛を意味します。ゆっくりと自然の流れに身を任せると、穏やかに関係が進展していくでしょう。大切なのは、焦らず、力まず、自然体のあなたを知ってもらうこと。",
  },
  {
    id: 15,
    name: "The Devil",
    img: "./img/15_The Devil.jpg",
    meaning: "悪魔(あくま)",
    keyword: "誘惑、執着、野望、望むこと",
    description1:
      "【悪魔】は、誘惑や執着などを表します。 感情に支配され衝動的な行動に出やすくなる予感。魔が差しやすく、誤った判断をしたり欲に溺れたりしがち。 人や物に対しての執着が強くなり、嫉妬や束縛の感情が強くなりがちだから注意してね。",
    description2:
      "【悪魔】のカードは快楽に身を任せた恋愛を意味します。 相手に対して執着心を抱いているかもしれません。 相手が自分以外と仲良くしているのを見て、嫉妬しちゃうかも。まずは理性的に考えてみることがポイント！",
  },
  {
    id: 16,
    name: "The Tower",
    img: "./img/16_The Tower.jpg",
    meaning: "塔(とう)",
    keyword: "事故、災難、悲劇、突然の崩壊",
    description1:
      "突然訪れる災難。まさにそれが【塔】のカード。その災難は避けることができず、受け入れざるを得ません。慌てずに、冷静に対処しましょう。",
    description2:
      "二人の関係に手痛い問題が起きる可能性がある【塔】のカード。ライバルが現れる可能性が・・・慌てず状況を悪化させないように注意しましょう。",
  },
  {
    id: 17,
    name: "The Star",
    img: "./img/17_The Star.jpg",
    meaning: "星",
    keyword: "未来の希望、信頼、リラクゼーション",
    description1:
      "【星】はあなたの前には無限の可能性が広がっていると教えてくれるカードです。過去に失敗したことや、後回しにしてきた苦手分野に取り組んでみるのもいいかも！周囲から無茶だと言われても物事が進展したり、新しい可能性に繋がります。自分自身の直感を信じてみてね。",
    description2:
      "【星】のカードはお互いを高め合う恋愛を意味します。自分磨きに意識を向けて取り組んでみるのが恋愛成就の鍵。あなた自身が自分らしく輝くことが大事！",
  },
  {
    id: 18,
    name: "The Moon",
    img: "./img/18_The Moon.jpg",
    meaning: "月",
    keyword: "精神的不安、ハッキリしない関係、安心できない恋模様",
    description1:
      "【月】のカードは、あなたが抱える不安や恐れを表しています。心当たりがある場合は、今こそ問題と向き合うとき。大丈夫。問題解決の日が近づいているよ！",
    description2:
      "【月】のカードは、不安定であいまいな恋愛を意味します。 相手の気持ちをあれこれ想像して、モヤモヤしちゃうかも。不安に惑わされずに自分を信じてね！",
  },
  {
    id: 19,
    name: "The Sun",
    img: "./img/19_The Sun.jpg",
    meaning: "太陽",
    keyword: "喜び、友情、達成",
    description1:
      "【太陽】は努力が実ることを表すカードです。運気は上昇傾向！成功が待っている明るい未来を信じて、突き進むことができるでしょう。",
    description2:
      "【太陽】カードは幸福な未来を表しています。太陽のように温かく、心地よい光に包まれる気分になりそう。相手との信頼が深まり、ふたりの関係が強まる予感。",
  },
  {
    id: 20,
    name: "The Aeon",
    img: "./img/20_The Aeon.jpg",
    meaning: "永劫(えいごう)",
    keyword: "過去へ戻る、成功、再誕生、ターニングポイント",
    description1:
      "【永劫】のカードは人生に大きな影響をもたらす転換期があると教えてくれています。転職や引っ越しなど、人生に大きな影響があるかも。決断に迷ったり気になることがあるなら、情報収集をしたり人に話すことで考えがまとまっていくよ！",
    description2:
      "【永劫】のカードはターニングポイントを表します。新しい見方や関わり方を考えることで明確な一歩を踏み出せるとき。今は求めようとせず、偶然の出会いを大事にしよう！",
  },
  {
    id: 21,
    name: "The Universe",
    img: "./img/21_The Universe.jpg",
    meaning: "宇宙",
    keyword: "完成、達成、開花",
    description1:
      "【宇宙】のカードは「完成、完結」を意味しています。完結するということは、０に戻ること。自己完結をする前にまず相談できる人を見つけよう！あなたが納得した形で完結を目指してね。",
    description2:
      "【宇宙】のカードは成就して幸せになれる恋愛を意味します。今よりさらに幸せな関係になるために、素直にアプローチしてみて！恋が成就する可能性が高いので、ありのまま自然体のあなたで。",
  },
];
